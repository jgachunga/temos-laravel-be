<?php

namespace App\Http\Controllers\API\V1;

use App\Exports\ArrayExport;
use App\Exports\OutletVisitExport;
use App\Exports\ReportExport;
use App\Exports\SurveyExport;
use App\Http\Controllers\AppBaseController;
use App\Http\Controllers\Controller;
use App\Models\Auth\User as AuthUser;
use App\Models\ClockIn;
use App\Models\Form;
use App\Models\OutletVisit;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Response;

class ReportsAPIController extends AppBaseController
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function saleByCustomer(Request $request)
    {
        $structures = $request->get('structures');
        $user_ids = AuthUser::whereIn('structure_id', $structures)->pluck('id');

        $sales = DB::table('customers as c')
                     ->select(DB::raw('c.name, c.phone_number, invoice_details.total_amount as total, invoice_details.quantity as qty, product_id, products.name as product_name, channels.name as channel, sale_structures.title as structure'))
                     ->whereIn('c.structure_id', $structures)
                     ->leftJoin('invoices', 'invoices.customer_id', '=', 'c.id')
                     ->leftJoin('invoice_details', 'invoice_details.invoice_id', '=', 'invoices.id')
                     ->leftJoin('products', 'invoice_details.product_id', '=', 'products.id')
                     ->leftJoin('users', 'users.id', '=', 'invoices.user_id')
                     ->leftJoin('channels', 'channels.id', '=', 'c.channel_id')
                     ->leftJoin('sale_structures', 'sale_structures.id', '=', 'c.structure_id')
                     ->groupBy('c.id', 'product_id')
                     ->get();

        return $this->sendResponse($sales->toArray(), 'Invoices retrieved successfully');
    }
    public function saleByCustomerRegion(Request $request)
    {
        $structures = $request->get('structures');
        $data = $request->all();
        $user_ids = AuthUser::whereIn('structure_id', $structures)->pluck('id');
        $start  = \Carbon\Carbon::createFromTimeString($data['fromdate'])->toDateString();
        $end  = \Carbon\Carbon::createFromTimeString($data['todate'])->toDateString();
        \DB::connection()->enableQueryLog();
        $salesquery = DB::table('invoices as i')
                    ->select(DB::raw('regions.name as region, areas.name as area, rts.name as route, i.stockist_id ,st.name as stockist, u.username as username, c.id as customer_id, c.sub_domain as customer,sc.first_name as sub_customer, i.id as invoice_id, p.name as p_name, p.code as code, c.id as category_id, cat.name as category, ids.quantity as qty, ids.price,  ids.total_amount as total, i.loctimestamp as invoice_date'))
                    ->leftJoin('invoice_details as ids', 'i.id', '=', 'ids.invoice_id')
                    ->leftJoin('products as p', 'ids.product_id', '=', 'p.id')
                    ->leftJoin('categories as cat', 'p.cat_id', '=', 'cat.id')
                    ->leftJoin('customers as c', 'i.customer_id', '=', 'c.id')
                    ->leftJoin('sub_customers as sc', 'i.sub_customer_id', '=', 'sc.id')
                    ->leftJoin('stockists as st', 'i.stockist_id', '=', 'st.id')
                    ->leftJoin('users as u', 'u.id', '=', 'i.user_id')
                    ->leftJoin('routes as rts', 'c.route_id', '=', 'rts.id')
                    ->leftJoin('areas', 'areas.id', '=', 'rts.area_id')
                    ->leftJoin('regions', 'regions.id', '=', 'areas.region_id')
                    ->where('i.raise_order', '!=', 1)
                    ->where('i.raise_stock', '!=', 1)
                    ->whereIn('c.structure_id', $structures)
                    ->orderBy('i.id', 'desc');

            $fullPath = null;
            if($data['search']){
                $salesquery->whereBetween(DB::raw('date(i.loctimestamp)'), [$start, $end]);
                $sales = $salesquery->paginate(50);

            }else{
                $sales = $salesquery->paginate(50);
            }
            if($data['export']){
                $filename = 'reports/customerRegionReport'.Carbon::now()->toDateTimeString().'.xlsx';
                $headings = [
                'Region',
                'Area',
                'Route',
                'Stockist ID',
                'Stockist',
                'Username',
                'Customer ID',
                'Customer',
                'Sub Customer',
                'Invoice ID',
                'Product',
                'Product Code',
                'Category ID',
                'Category',
                'Quantity',
                'Price',
                'Sub Total',
                'Invoice Date',
                ];
                $store = Excel::store((new ReportExport)->forQuery($salesquery, $headings), $filename, 'local', 'Xlsx');

                // dd($fullPath);
                return $this->sendResponse(["path"=> $filename], 'Sale by customer report retrieved successfully');
            }


        return $this->sendResponse($sales->toArray(), 'Sale by customer report retrieved successfully');
    }
    public function downloadFile(Request $request)
    {
        $file_name = $request->path;
        // dd(Storage::path());
        return response()->download(Storage::path($file_name))->deleteFileAfterSend(true);
    }
    public function saleByCustomerRegionOrder(Request $request)
    {
        $structures = $request->get('structures');
        $data = $request->all();
        $user_ids = AuthUser::whereIn('structure_id', $structures)->pluck('id');
        $start  = \Carbon\Carbon::createFromTimeString($data['fromdate'])->toDateString();
        $end  = \Carbon\Carbon::createFromTimeString($data['todate'])->toDateString();
        \DB::connection()->enableQueryLog();
        $salesquery = DB::table('invoices as i')
                    ->select(DB::raw('regions.name as region, areas.name as area, rts.name as route, i.stockist_id ,st.name as stockist, u.username as username, c.sub_domain as customer,sc.first_name as sub_customer, i.id as invoice_id, p.name as p_name, p.code as code, c.id as category_id, cat.name as category, ids.quantity as qty, ids.price,  ids.total_amount as total, i.loctimestamp as invoice_date'))
                    ->leftJoin('invoice_details as ids', 'i.id', '=', 'ids.invoice_id')
                    ->leftJoin('products as p', 'ids.product_id', '=', 'p.id')
                    ->leftJoin('categories as cat', 'p.cat_id', '=', 'cat.id')
                    ->leftJoin('customers as c', 'i.customer_id', '=', 'c.id')
                    ->leftJoin('sub_customers as sc', 'i.sub_customer_id', '=', 'sc.id')
                    ->leftJoin('stockists as st', 'i.stockist_id', '=', 'st.id')
                    ->leftJoin('users as u', 'u.id', '=', 'i.user_id')
                    ->leftJoin('routes as rts', 'c.route_id', '=', 'rts.id')
                    ->leftJoin('areas', 'areas.id', '=', 'rts.area_id')
                    ->leftJoin('regions', 'regions.id', '=', 'areas.region_id')
                    ->where('i.raise_order', 1)
                    ->whereIn('c.structure_id', $structures)
                    ->orderBy('i.id', 'desc');

            $fullPath = null;
            if($data['search']){
                $salesquery->whereBetween(DB::raw('date(i.loctimestamp)'), [$start, $end]);
                $sales = $salesquery->paginate(50);

            }else{
                $sales = $salesquery->paginate(50);
            }

            if($data['export']){
                $filename = 'reports/customerRegionReport'.Carbon::now()->toDateTimeString().'.xlsx';
                $headings = [
                'Region',
                'Area',
                'Route',
                'Stockist ID',
                'Stockist',
                'Username',
                'Customer',
                'Sub Customer',
                'Invoice ID',
                'Product',
                'Product Code',
                'Category ID',
                'Category',
                'Quantity',
                'Price',
                'Sub Total',
                'Invoice Date',
                ];
                $store = Excel::store((new ReportExport)->forQuery($salesquery, $headings), $filename, 'local', 'Xlsx');

                // dd($fullPath);
                return $this->sendResponse(["path"=> $filename], 'Sale by customer report retrieved successfully');
            }


        return $this->sendResponse($sales->toArray(), 'Sale by customer report retrieved successfully');
    }
    public function saleByCustomerRegionRPre(Request $request)
    {
        $structures = $request->get('structures');
        $data = $request->all();
        $user_ids = AuthUser::whereIn('structure_id', $structures)->pluck('id');
        $start  = \Carbon\Carbon::createFromTimeString($data['fromdate'])->toDateTimeString();
        $end  = \Carbon\Carbon::createFromTimeString($data['todate'])->toDateTimeString();
        \DB::connection()->enableQueryLog();
        $salesquery = DB::table('invoices as i')
                     ->select(DB::raw('sc.name as sub_customer_name, customers.name as customer_name, users.username as username, invoices.user_id as user_id, invoices.loctimestamp as timestamp, sc.phone_number, SUM(invoice_details.total_amount) as total, SUM(invoice_details.quantity) as qty, MAX(invoice_details.created_at) as created_at, product_id, products.name as product_name, channels.name as channel, sale_structures.title as structure, regions.name as region, areas.name as area, stockists.name as stockist, routes.name as route'))
                     ->whereIn('sc.structure_id', $structures)
                     ->leftJoin('customers', 'customers.id', '=', 'sc.customer_id')
                     ->leftJoin('routes', 'routes.id', '=', 'customers.route_id')
                     ->leftJoin('stockists', 'stockists.id', '=', 'routes.stockist_id')
                     ->leftJoin('areas', 'areas.id', '=', 'stockists.area_id')
                     ->leftJoin('regions', 'regions.id', '=', 'areas.region_id')
                     ->leftJoin('invoices', 'invoices.customer_id', '=', 'sc.customer_id')
                     ->leftJoin('invoice_details', 'invoice_details.invoice_id', '=', 'invoices.id')
                     ->leftJoin('products', 'invoice_details.product_id', '=', 'products.id')
                     ->leftJoin('users', 'users.id', '=', 'invoices.user_id')
                     ->leftJoin('channels', 'channels.id', '=', 'customers.channel_id')
                     ->leftJoin('sale_structures', 'sale_structures.id', '=', 'sc.structure_id')
                     ->where('invoices.raise_order', '!=', 1)
                     ->orderBy('invoices.id', 'desc')
                     ->groupBy('invoice_details.product_id','invoices.invoice_id','invoices.user_id','invoices.loctimestamp', 'sc.id');

            if($data['search']){
                $salesquery->whereBetween('invoices.loctimestamp', [$start, $end]);

                $sales = $salesquery->paginate(50);

            }else{
                $sales = $salesquery->paginate(50);
            }
            $queries = \DB::getQueryLog();
        return $this->sendResponse($sales->toArray(), 'Sale by customer report retrieved successfully');
    }
    public function getSurvey($form_id, Request $request){
        $data = $request->all();
        $startObj  = \Carbon\Carbon::createFromTimeString($data['fromdate']);
        $start = $startObj->format('Y/m/d');
        $endObj  = \Carbon\Carbon::createFromTimeString($data['todate']);$end =$endObj->format('Y/m/d');

        $query_sql = 'call survey_report_by_form_id('.$form_id.',"'.$start.'","'.$end.'")';

        $survey = DB::select(
            $query_sql
        );
        $form = Form::find($form_id);
        $headings = [];
        $filename = 'reports/'.$form->name.Carbon::now()->toDateTimeString().' from '.$startObj->toDateTimeString().' to '.$endObj->toDateTimeString().'.xlsx';

        $store = false;
        if(!empty($survey)){
            $vars = get_object_vars($survey[0]);
            $headings = array_keys($vars);
            $store = Excel::store((new SurveyExport)->forQuery($survey, $headings), $filename, 'local', 'Xlsx');

        }
        return $this->sendResponse(["path"=> $filename, "store" => $store], 'Survey report retrieved successfully');
    }
    public function dailySales(Request $request)
    {
        $structures = $request->get('structures');
        $data = $request->all();
        $user_ids = AuthUser::whereIn('structure_id', $structures)->pluck('id');

        $start  = \Carbon\Carbon::createFromTimeString($data['fromdate'])->toDateString();
        $end  = \Carbon\Carbon::createFromTimeString($data['todate'])->toDateString();

        \DB::connection()->enableQueryLog();
        $daily_sales = DB::select(
            "call daily_sales('".$start."', '".$end."')"
        );

        $fullPath = null;

        if($data['export']){
            $filename = 'reports/dailySales'.Carbon::now()->toDateTimeString().'.xlsx';
            $headings = [
            'Username',
            'Usert ID',
            'Total',
            'Coverage',
            'Structure ID',
            ];
            $store = Excel::store((new ArrayExport($daily_sales, $headings)), $filename, 'local', 'Xlsx');

            // dd($fullPath);
            return $this->sendResponse(["path"=> $filename], 'Sale by customer report retrieved successfully');
        }


        return $this->sendResponse($daily_sales, 'Sale by customer report retrieved successfully');
    }
    public function coverage(Request $request)
    {
        $structures = $request->get('structures');
        $data = $request->all();
        $user_ids = AuthUser::whereIn('structure_id', $structures)->pluck('id');

        $start  = \Carbon\Carbon::createFromTimeString($data['fromdate'])->toDateString();

        $coverage = DB::select(
            "call coverage('".$start."')"
        );

        $fullPath = null;

        if($data['export']){
            $filename = 'reports/dailySales'.Carbon::now()->toDateTimeString().'.xlsx';
            $headings = [
            'Visited',
            'Usert ID',
            'UserName'
            ];
            $store = Excel::store((new ArrayExport($coverage, $headings)), $filename, 'local', 'Xlsx');

            // dd($fullPath);
            return $this->sendResponse(["path"=> $filename], 'Sale by customer report retrieved successfully');
        }


        return $this->sendResponse($coverage, 'Sale by customer report retrieved successfully');
    }
    public function saleByProduct(Request $request)
    {
        $structures = $request->get('structures');
        $data = $request->all();
        $start  = \Carbon\Carbon::createFromTimeString($data['fromdate'])->toDateTimeString();
        $end  = \Carbon\Carbon::createFromTimeString($data['todate'])->toDateTimeString();

        $salesquery = DB::table('products as p')
                     ->select([DB::raw('p.name, p.desc, sum(invoice_details.total_amount) as total, sum(invoice_details.quantity) as qty, p.id, sale_structures.title as structure'),DB::raw('max(invoice_details.created_at) as created_at')])
                     ->whereIn('p.structure_id', $structures)
                     ->leftJoin('invoice_details', 'invoice_details.product_id', '=', 'p.id')
                     ->leftJoin('sale_structures', 'sale_structures.id', '=', 'p.structure_id')
                     ->groupBy('p.id')
                     ->orderByDesc('created_at');
                if($data['search']){
                    $salesquery->whereBetween('invoice_details.created_at', [$start, $end]);
                    $sales = $salesquery->paginate(10);
                }else{
                    $sales = $salesquery->paginate(10);
                }

        return $this->sendResponse($sales->toArray(), 'Product report retrieved successfully');
    }
    public function getClockins(Request $request)
    {
        $structures = $request->get('structures');
        $data = $request->all();
        $start  = \Carbon\Carbon::createFromTimeString($data['fromdate'])->toDateTimeString();
        $end  = \Carbon\Carbon::createFromTimeString($data['todate'])->toDateTimeString();
        $user_ids = AuthUser::whereIn('structure_id', $structures)->pluck('id');
        $clockin_query = ClockIn::
                with('user', 'clocktype', 'user.structure')
                ->whereIn('user_id', $user_ids)->orderByDesc('created_at');

        if($data['search']){
            $clockin_query->whereBetween('created_at', [$start, $end]);
            $clockins = $clockin_query->paginate(10);
        }else{
            $clockins = $clockin_query->paginate(10);
        }

        return $this->sendResponse($clockins->toArray(), 'Clockins retrieved successfully');
    }
    public function outletVisits(Request $request)
    {
        $structures = $request->get('structures');
        $data = $request->all();
        $start  = \Carbon\Carbon::createFromTimeString($data['fromdate'])->toDateTimeString();
        $end  = \Carbon\Carbon::createFromTimeString($data['todate'])->toDateTimeString();
        $user_ids = AuthUser::whereIn('structure_id', $structures)->pluck('id');
        $outlets_query = OutletVisit::
                with('user', 'customer')
                ->whereIn('user_id', $user_ids)
                ->orderByDesc('created_at');

        if($data['search']){
            $outlets_query->whereBetween('created_at', [$start, $end]);
            $outlet_visits = $outlets_query->paginate(50);
        }else{
            $outlet_visits = $outlets_query->paginate(50);
        }
        if($data['export']){
            $outletVisitQuery = DB::table('outlet_visits as ov')
            ->select('customers.name', 'users.username', 'status', 'current_status', 'option_selected', 'other_reasons', 'started_timestamp', 'completed_timestamp', 'ov.lat', 'ov.long', 'geotimestamp')
            ->whereIn('ov.user_id', $user_ids)
            ->leftJoin('customers', 'ov.customer_id', '=', 'customers.id')
            ->leftJoin('users', 'ov.user_id', '=', 'users.id')
            ->orderByDesc('ov.geotimestamp');

            if($data['search']){
                $outletVisitQuery->whereBetween('ov.geotimestamp', [$start, $end]);
            }

            $filename = 'reports/outletVisitsReport'.Carbon::now()->toDateTimeString().'.xlsx';

            $headings = [
            'Customer',
            'Username',
            'Status',
            'Current Status',
            'Option Selected',
            'Other Reasons',
            'Started',
            'Completed',
            'Time Spent',
            'Address',
            'Location Mocked',
            'GeoTimestamp',
            'Lat',
            'Long'
            ];

            Excel::store((new OutletVisitExport)->forQuery($outletVisitQuery, $headings), $filename, 'local', 'Xlsx');

            return $this->sendResponse(["path"=> $filename], 'Outlet Visits report retrieved successfully');
        }

        return $this->sendResponse($outlet_visits->toArray(), 'Outlet visits retrieved successfully');
    }

}

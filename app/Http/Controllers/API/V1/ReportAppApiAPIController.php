<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\API\V1\CreateReportAppApiAPIRequest;
use App\Http\Requests\API\V1\UpdateReportAppApiAPIRequest;
use App\Models\ReportAppApi;
use App\Repositories\Backend\ReportAppApiRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\ReportAppApiResource;
use App\Models\UserRoute;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Response;

/**
 * Class ReportAppApiController
 * @package App\Http\Controllers\API\V1
 */

class ReportAppApiAPIController extends AppBaseController
{
    /** @var  ReportAppApiRepository */
    private $reportAppApiRepository;

    public function __construct(ReportAppApiRepository $reportAppApiRepo)
    {
        $this->reportAppApiRepository = $reportAppApiRepo;
    }

    /**
     * Display a listing of the ReportAppApi.
     * GET|HEAD /reportAppApis
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $reportAppApis = $this->reportAppApiRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(ReportAppApiResource::collection($reportAppApis), 'Report App Apis retrieved successfully');
    }

    public function visitsSummary(){
        $user_id = Auth::guard('api')->user()->id;
        $totalCust = DB::table('customers')
        ->select(DB::raw('count(*) as customers'))
        ->where('user_id', $user_id)
        ->first();
        $visited = DB::table('customers')
                     ->select(DB::raw('count(*) as visited'))
                     ->where('user_id', $user_id)
                     ->whereRaw('MONTH(visited_at) = MONTH(CURRENT_DATE())')
                     ->whereRaw('YEAR(visited_at) = YEAR(CURRENT_DATE())')
                     ->first();

        return $this->sendResponse(['total' => $totalCust->customers, 'visited' => $visited->visited], 'Report App Apis retrieved successfully');
    }
    public function salesGraph(){
        $user_id = Auth::guard('api')->user()->id;

        $sales = DB::table('invoices')
                     ->select(DB::raw('sum(sub_total) as sum, day(loctimestamp) as day'))
                     ->where('user_id', $user_id)
                     ->whereRaw('date(loctimestamp) between date_sub(now(),INTERVAL 1 WEEK) and now()')
                     ->groupByRaw('day(loctimestamp)')
                     ->limit(7)
                     ->get();



        return $this->sendResponse($sales->toArray(), 'Report App Apis retrieved successfully');
    }
    public function skuList(){
        $user_id = Auth::guard('api')->user()->id;

        $overallSum = DB::table('invoices')
        ->select(DB::raw('sum(total_amount) as sum'))
        ->leftJoin('invoice_details', 'invoice_details.invoice_id', '=', 'invoices.id')
        ->leftJoin('products', 'invoice_details.product_id', '=', 'products.id')
        ->where('user_id', $user_id)
        ->whereRaw('date(loctimestamp) between date_sub(now(),INTERVAL 1 MONTH) and now()')
        ->first();
        $overallSum = $overallSum->sum;

        $salesList = DB::table('invoices')
                     ->select(DB::raw('sum(total_amount) as sum, product_id, name'))
                     ->leftJoin('invoice_details', 'invoice_details.invoice_id', '=', 'invoices.id')
                     ->leftJoin('products', 'invoice_details.product_id', '=', 'products.id')
                     ->where('user_id', $user_id)
                     ->whereRaw('date(loctimestamp) between date_sub(now(),INTERVAL 1 MONTH) and now()')
                     ->groupByRaw('product_id')
                     ->orderByDesc('sum')
                     ->get();

        $SalesListCollection = collect($salesList);

        $transformed = $SalesListCollection->map(function ($item, $key) use($overallSum) {
            $percentage = number_format(($item->sum/ $overallSum) * 100, 2);
            return [
                'sumTotal' => $item->sum,
                'product_id' => $item->product_id,
                'name' => $item->name,
                'sum' => $percentage.'%'
            ];
        });

        return $this->sendResponse($transformed, 'Report App Apis retrieved successfully');
    }
    public function userSummary(){
        $user_id = Auth::guard('api')->user()->id;
        // $user_id = 49;

        $dateToday  = \Carbon\Carbon::now();
        $weekStartDate = $dateToday->startOfWeek()->format('Y-m-d');
        $weekEndDate = $dateToday->endOfWeek()->format('Y-m-d');

        $todaySalesSum = DB::table('invoices')
                     ->select(DB::raw('sum(sub_total) as sum'))
                     ->where('user_id', $user_id)
                     ->where('raise_stock', '!=', 1)
                     ->whereRaw('date(loctimestamp) = date(now())')
                     ->first();

        $monthsSales = DB::table('invoices')
                    ->select(DB::raw('sum(sub_total) as sum'))
                    ->where('user_id', $user_id)
                    ->where('raise_stock', '!=', 1)
                    ->whereMonth('invoices.loctimestamp', [$dateToday->month])
                    ->whereYear('invoices.loctimestamp', [$dateToday->year])
                    ->first();
        $weeklySales = DB::table('invoices')
                    ->select(DB::raw('sum(sub_total) as sum'))
                    ->where('user_id', $user_id)
                    ->where('raise_stock', '!=', 1)
                    ->whereBetween('invoices.loctimestamp', [$weekStartDate, $weekEndDate])
                    ->first();

        $monthsVisits = DB::table('customer_survey_details')
                    ->select(DB::raw('count(*) as visits'))
                    ->where('user_id', $user_id)
                    ->whereMonth('customer_survey_details.activeDate', [$dateToday->month])
                    ->whereYear('customer_survey_details.activeDate', [$dateToday->year])
                    ->first();

        $monthsDistinctVisits = DB::table('customer_survey_details')
        ->select(DB::raw('count(distinct(customer_id)) as visits'))
        ->where('user_id', $user_id)
        ->whereMonth('customer_survey_details.activeDate', [$dateToday->month])
        ->whereYear('customer_survey_details.activeDate', [$dateToday->year])
        ->first();

        $todayVisits = DB::table('customer_survey_details')
                     ->select(DB::raw('count(*) as visits'))
                     ->where('user_id', $user_id)
                     ->whereRaw('date(activeDate) = date(now())')
                     ->first();

        $todayDistinctVisits = DB::table('customer_survey_details')
                     ->select(DB::raw('count(distinct(customer_id)) as visits'))
                     ->where('user_id', $user_id)
                     ->whereRaw('date(activeDate) = date(now())')
                     ->first();

       $allCustomers = DB::table('user_routes as ur')
        ->select(DB::raw('count(*) as allcust'))
        ->leftJoin('customers', 'customers.route_id', '=', 'ur.route_id')
        ->where('ur.user_id', $user_id)
        ->first();
        
        $summary = [
            'todaySalesSum' => $todaySalesSum->sum,
            'monthsSales' => $monthsSales->sum,
            'monthsVisits' => $monthsVisits->visits,
            'todayVisits' => $todayVisits->visits,
            'monthsDistinctVisits' => $monthsDistinctVisits->visits,
            'todayDistinctVisits' => $todayDistinctVisits->visits,
            'all' => $allCustomers->allcust,
            'weeklySales' => $weeklySales->sum,
        ];

        return $this->sendResponse($summary, 'Report App Apis retrieved successfully');
    }

    /**
     * Store a newly created ReportAppApi in storage.
     * POST /reportAppApis
     *
     * @param CreateReportAppApiAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateReportAppApiAPIRequest $request)
    {
        $input = $request->all();

        $reportAppApi = $this->reportAppApiRepository->create($input);

        return $this->sendResponse(new ReportAppApiResource($reportAppApi), 'Report App Api saved successfully');
    }

    /**
     * Display the specified ReportAppApi.
     * GET|HEAD /reportAppApis/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var ReportAppApi $reportAppApi */
        $reportAppApi = $this->reportAppApiRepository->find($id);

        if (empty($reportAppApi)) {
            return $this->sendError('Report App Api not found');
        }

        return $this->sendResponse(new ReportAppApiResource($reportAppApi), 'Report App Api retrieved successfully');
    }

    /**
     * Update the specified ReportAppApi in storage.
     * PUT/PATCH /reportAppApis/{id}
     *
     * @param int $id
     * @param UpdateReportAppApiAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateReportAppApiAPIRequest $request)
    {
        $input = $request->all();

        /** @var ReportAppApi $reportAppApi */
        $reportAppApi = $this->reportAppApiRepository->find($id);

        if (empty($reportAppApi)) {
            return $this->sendError('Report App Api not found');
        }

        $reportAppApi = $this->reportAppApiRepository->update($input, $id);

        return $this->sendResponse(new ReportAppApiResource($reportAppApi), 'ReportAppApi updated successfully');
    }

    /**
     * Remove the specified ReportAppApi from storage.
     * DELETE /reportAppApis/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var ReportAppApi $reportAppApi */
        $reportAppApi = $this->reportAppApiRepository->find($id);

        if (empty($reportAppApi)) {
            return $this->sendError('Report App Api not found');
        }

        $reportAppApi->delete();

        return $this->sendSuccess('Report App Api deleted successfully');
    }
}

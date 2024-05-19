<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\API\V1\CreateCurrentStatusesAPIRequest;
use App\Http\Requests\API\V1\UpdateCurrentStatusesAPIRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Models\Auth\User;
use App\Models\ClockIn;
use App\Models\Invoice;
use App\Models\UserTarget;
use App\Repositories\Backend\DashboardRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Response;

/**
 * Class CurrentStatusesController
 * @package App\Http\Controllers\API\V1
 */

class DashboardAPIController extends AppBaseController
{
    /** @var  CurrentStatusesRepository */
    private $currentStatusesRepository;

    public function __construct(DashboardRepository $currentStatusesRepo)
    {
        $this->currentStatusesRepository = $currentStatusesRepo;
    }

    /**
     * Display a listing of the CurrentStatuses.
     * GET|HEAD /currentStatuses
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $user_id = Auth::guard('api')->user()->id;
        $target = UserTarget::where('user_id', $user_id)->first();
        $user_target = 0;
        if($target){
            $user_target = $target->target;
        }
        
        $now = Carbon::now();
        $to = $now->toDateTimeString();
        $from = $now->firstOfMonth()->toDateTimeString();
        $today = Carbon::now()->toDateString();
        
        $salesmonth = DB::table('invoices')
        ->select(DB::raw('sum(grand_total) as total'))
        ->where('user_id', $user_id)
        ->whereBetween('loctimestamp', [$from, $to])
        ->where('raise_order', 0)->where('raise_stock', 0)
        ->first();
        $salesTotal = 0;
        $sales_vs_target = 0;
        $salesTotal = $salesmonth ? $salesmonth->total : 0;
        $sales_vs_target = $salesmonth&&$user_target ? round($salesTotal/$user_target, 2) : 0;
        
        $salesday = DB::table('invoices')
        ->select(DB::raw('sum(grand_total) as total'))
        ->where('user_id', $user_id)
        ->whereDate('loctimestamp', [$today])
        ->where('raise_order', 0)->where('raise_stock', 0)
        ->first();

        $salesdaysum = $salesday ? $salesday->total : 0;
        
        $month_visits= DB::table('outlet_visits')
        ->where('user_id', $user_id)
        ->whereBetween('geotimestamp', [$from, $to])
        ->count(DB::raw('DISTINCT customer_id'));

        
        $today_visits= DB::table('outlet_visits')
        ->where('user_id', $user_id)
        ->whereDate('geotimestamp', [$today])
        ->count(DB::raw('DISTINCT customer_id'));

        
        $data = [
            "today_visits" => $today_visits,
            "month_visits" => $month_visits,
            "month_sales" => round($salesTotal, 0),
            "today_sales" => round($salesdaysum, 0),
            "sale_target" => $sales_vs_target,
        ];
        
        return $this->sendResponse($data, 'User data retrieved successfully');
    }
    public function indexAdmin(Request $request)
    {
        $structures = $request->only('structures');
        DB::enableQueryLog();
        $user_ids = User::whereIn('structure_id', $structures['structures'])->pluck('id');
        
        $user_ids = $user_ids->toArray();
        
        $now = Carbon::now();
        $to = $now->toDateTimeString();
        $from = $now->firstOfMonth()->toDateTimeString();
        $today = Carbon::now()->toDateString();
        
        $salesmonth = Invoice::
        select(DB::raw('sum(grand_total) as total'))
        ->whereBetween('loctimestamp', [$from, $to])
        ->where('raise_order', 0)->where('raise_stock', 0)
        ->first();
        
        $salesTotal = 0;
        $sales_vs_target = 0;
        $salesTotal = $salesmonth ? $salesmonth->total : 0;
        
        $salesday = Invoice::
        select(DB::raw('sum(grand_total) as total'))
        ->whereDate('loctimestamp', [$today])
        ->where('raise_order', 0)->where('raise_stock', 0)
        ->first();

        $salesdaysum = $salesday ? $salesday->total : 0;
        
        $month_visits= DB::table('outlet_visits')
        ->whereBetween('geotimestamp', [$from, $to])
        ->whereIn('user_id', $user_ids)
        ->count(DB::raw('DISTINCT customer_id'));

        
        $today_visits= DB::table('outlet_visits')
        ->whereDate('geotimestamp', [$today])
        ->whereIn('user_id', $user_ids)
        ->count(DB::raw('DISTINCT customer_id'));

        
        $data = [
            "today_visits" => $today_visits,
            "month_visits" => $month_visits,
            "month_sales" => round($salesTotal, 0),
            "today_sales" => round($salesdaysum, 0),
        ];
        
        return $this->sendResponse($data, 'User data retrieved successfully');
    }

    public function chart(Request $request)
    {
        $data = Invoice::select(
                DB::raw("(DATE_FORMAT(loctimestamp, '%b')) as name"),
                DB::raw("(sum(grand_total)) as uv")
                )
                ->whereRaw('loctimestamp < Now()')
                ->whereRaw('loctimestamp > DATE_ADD(Now(), INTERVAL- 6 MONTH)')
                // ->orderBy('created_at', 'desc')
                ->groupBy(DB::raw("DATE_FORMAT(loctimestamp, '%b')"))
                ->get();
        return $this->sendResponse($data, 'User data retrieved successfully');
    }
    public function userSummary(Request $request)
    {
        $structures = $request->only('structures');
        
        $users = User::where('is_rep', 1)
                ->whereIn('structure_id', $structures)->get();
        $data = [];
        foreach ($users as $key => $user) {
            # code...
            $user_item = [];
            $user_id = $user->id;
            $user_data = [
                "id" => $user->id,
                "username" => $user->username,
            ];
            $target = UserTarget::where('user_id', $user_id)->first();
            $user_target = 0;
            if($target){
                $user_target = $target->target;
            }
            
            $now = Carbon::now();
            $to = $now->toDateTimeString();
            $from = $now->firstOfMonth()->toDateTimeString();
            $today = Carbon::now()->toDateString();
            
            $salesmonth = DB::table('invoices')
            ->select(DB::raw('sum(grand_total) as total'))
            ->where('user_id', $user_id)
            ->whereBetween('loctimestamp', [$from, $to])
            ->where('raise_order', 0)->where('raise_stock', 0)
            ->first();
            $salesTotal = 0;
            $sales_vs_target = 0;
            $salesTotal = $salesmonth ? $salesmonth->total : 0;
            $sales_vs_target = $salesmonth&&$user_target ? round($salesTotal/$user_target, 2) : 0;
            
            $allsales = DB::table('invoices')
            ->select(DB::raw('sum(grand_total) as total'))
            ->where('user_id', $user_id)
            ->where('raise_order', 0)->where('raise_stock', 0)
            ->first();
            $allSales = $allsales ? $allsales->total : 0;

            $salesday = DB::table('invoices')
            ->select(DB::raw('sum(grand_total) as total'))
            ->where('user_id', $user_id)
            ->whereDate('loctimestamp', [$today])
            ->where('raise_order', 0)->where('raise_stock', 0)
            ->groupBy('user_id')
            ->first();

            $salesdaysum = $salesday ? $salesday->total : 0;
            
            $month_visits= DB::table('outlet_visits')
            ->where('user_id', $user_id)
            ->whereBetween('geotimestamp', [$from, $to])
            ->count(DB::raw('DISTINCT customer_id'));

            
            $today_visits= DB::table('outlet_visits')
            ->where('user_id', $user_id)
            ->whereDate('geotimestamp', [$today])
            ->count(DB::raw('DISTINCT customer_id'));

            $user_data["today_visits"] = $today_visits;
            $user_data["month_visits"] = $month_visits;
            $user_data["month_sales"] = round($salesTotal, 0);
            $user_data["today_sales"] = round($salesdaysum, 0);
            $user_data["sale_target"] = $sales_vs_target;
            $user_data["salestotal"] = $allSales;
            
            $clockin = ClockIn::where('user_id', $user_id)
                    ->whereDate('geotimestamp', [$today])
                    ->orderBy('geotimestamp', 'asc')
                    ->whereNotNull('clock_in')
                    ->first();
            
            $user_data['clockin'] = $clockin ? $clockin->clock_in : '' ;
            $user_data['img_url'] = $clockin ? $clockin->img_url : '' ;
            $user_data['address'] = $clockin ? $clockin->address : '' ;
            
            $data[] = $user_data;

        }
        return $this->sendResponse($data, 'User data retrieved successfully');
    }
    /**
     * Store a newly created CurrentStatuses in storage.
     * POST /currentStatuses
     *
     * @param CreateCurrentStatusesAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateCurrentStatusesAPIRequest $request)
    {
        $input = $request->all();

        $currentStatuses = $this->currentStatusesRepository->create($input);

        return $this->sendResponse($currentStatuses->toArray(), 'Current Statuses saved successfully');
    }

    /**
     * Display the specified CurrentStatuses.
     * GET|HEAD /currentStatuses/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var CurrentStatuses $currentStatuses */
        $currentStatuses = $this->currentStatusesRepository->find($id);

        if (empty($currentStatuses)) {
            return $this->sendError('Current Statuses not found');
        }

        return $this->sendResponse($currentStatuses->toArray(), 'Current Statuses retrieved successfully');
    }

    /**
     * Update the specified CurrentStatuses in storage.
     * PUT/PATCH /currentStatuses/{id}
     *
     * @param int $id
     * @param UpdateCurrentStatusesAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCurrentStatusesAPIRequest $request)
    {
        $input = $request->all();

        /** @var CurrentStatuses $currentStatuses */
        $currentStatuses = $this->currentStatusesRepository->find($id);

        if (empty($currentStatuses)) {
            return $this->sendError('Current Statuses not found');
        }

        $currentStatuses = $this->currentStatusesRepository->update($input, $id);

        return $this->sendResponse($currentStatuses->toArray(), 'CurrentStatuses updated successfully');
    }

    /**
     * Remove the specified CurrentStatuses from storage.
     * DELETE /currentStatuses/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var CurrentStatuses $currentStatuses */
        $currentStatuses = $this->currentStatusesRepository->find($id);

        if (empty($currentStatuses)) {
            return $this->sendError('Current Statuses not found');
        }

        $currentStatuses->delete();

        return $this->sendResponse($id, 'Current Statuses deleted successfully');
    }
}

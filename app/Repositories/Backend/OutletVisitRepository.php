<?php

namespace App\Repositories\Backend;

use App\Models\OutletVisit;
use App\Models\UserLocationHistory;
use App\Models\UserStatus;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Log;

/**
 * Class OutletVisitRepository
 * @package App\Repositories\Backend
 * @version February 23, 2020, 7:21 pm EAT
*/

class OutletVisitRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'form_id',
        'customer_id',
        'current_status_id',
        'status_id',
        'status',
        'reason',
        'other_reasons',
        'has_answers',
        'timestamp',
        'started_timestamp',
        'lat',
        'long',
        'accuracy',
        'mocked',
        'geotimestamp'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function __construct(OutletVisit $model)
    {
        $this->model = $model;
    }
    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function create(array $data) : OutletVisit
    {
        $structure_id = Auth::guard('api')->user()->logged_structure_id;
        if($structure_id==null){
            $structure_id = Auth::guard('api')->user()->structure_id;
        }
        $user_id = Auth::guard('api')->user()->id;
        $data['structure_id'] = $structure_id;

        $status = "";
        $status_id = null;
        $other_reason = null;
        $completed_at = null;
        if(!isset($data['close_outlet'])){
            \Log::debug($data['timestamp']);
            $start  = \Carbon\Carbon::createFromTimestamp($data['timestamp']/1000)->toDateTimeString();
            $position = $data['position'];

            $date = \Carbon\Carbon::createFromTimestamp($position['timestamp']/1000)->toDateTimeString();
            if($data['option']=="start"){
                $status = "Started Outlet";
                $status_id = 6;
            }else if($data['option']=="closed"){
                $status = "Outlet marked as closed";
                $status_id = 7;
                $completed_at = $date;
            }else if($data['option']=="cancelled"){
                $status = "Outlet data entry is cancelled";
                $status_id = 8;
                $completed_at = $date;
            }else if($data['option']=="other"){
                $status = "Other reason";
                $status_id = 9;
                $other_reason = $data['otherreason'];
                $completed_at = $date;
            }
            $input_arrray = [
                "user_id" => $user_id,
                "customer_id" => $data['customer_id'],
                "address" => isset($data['address']) ? $data['address'] : null,
                'started_timestamp' => $start,
                'status'=> $status,
                'other_reasons'=> $other_reason,
                'completed_timestamp'=> $completed_at,
                'current_status_id'=> $status_id,
                'lat' => $position['coords']['latitude'],
                'long' => $position['coords']['longitude'],
                'accuracy' => $position['coords']['accuracy'],
                'mocked' => $position['mocked'],
                'geotimestamp'=> $date,
            ];
            return DB::transaction(function () use ($input_arrray) {
                $outlet_visit = $this->model::create($input_arrray);
                $input_arr_copy = $input_arrray;
                if ($outlet_visit) {
                    $input_arr_copy['timestamp'] = $input_arrray['started_timestamp'];
                    UserLocationHistory::create($input_arr_copy);
                    $user_status = UserStatus::updateOrCreate(
                        ['user_id' => $input_arrray['user_id']],
                        $input_arrray
                    );
                }
                if ($outlet_visit) {
                    return $outlet_visit;
                }

                throw new \Exception('An error occured attempting to create client');
            });
        }else{
            $end  = \Carbon\Carbon::createFromTimestamp($data['close_timestamp']/1000)->toDateTimeString();
            $outlet_visit_id = $data['outlet_visit_id'];
            $input_arrray = [
                'completed_timestamp'=> $end,
                'current_status_id'=> 10,
                'status' => "Closed Outlet",
            ];
            $outlet_visit = OutletVisit::find($outlet_visit_id);

            if($outlet_visit!=null){
                $outlet_visit->completed_timestamp = $end;
                $outlet_visit->status = "Completed";
                $outlet_visit = tap($outlet_visit)->save();
                $user_status = UserStatus::updateOrCreate(
                    ['user_id' => $user_id],
                    [
                        'customer_id' => null,
                        'current_status_id' => null,
                    ]
                );
                return $outlet_visit;
            }
            return null;
        }

    }
    protected function OutletVisitExists($name) : bool
    {
        return $this->model
            ->where('name', strtolower($name))
            ->count() > 0;
    }
    public function find($id) : OutletVisit
    {
        return $this->model->find($id);
    }
}

<?php

namespace App\Repositories\Backend;

use App\Helpers\LocationHelper;
use App\Models\ClockIn;
use App\Models\UserLocationHistory;
use App\Models\UserStatus;
use App\Repositories\BaseRepository;
use Auth;
use Carbon\Carbon;
use DB;

/**
 * Class ClockInRepository
 * @package App\Repositories\Backend
 * @version February 24, 2020, 3:29 pm EAT
*/

class ClockInRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'clock_type',
        'img_url',
        'clock_in',
        'clock_out',
        'lat',
        'long',
        'accuracy',
        'mocked',
        'geotimestamp',
        'address'
    ];
    public function __construct(ClockIn $model)
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
    public function create(array $data) : ClockIn
    {
        $structure_id = Auth::guard('api')->user()->logged_structure_id;
        $user_id = Auth::guard('api')->user()->id;
        if($structure_id==null){
            $structure_id = Auth::guard('api')->user()->structure_id;
        }
        $data['structure_id'] = $structure_id;
        // Make sure it doesn't already exist
        $position = (object)$data['location'];

        $user_id = auth('api')->user()->id ?? null;
        $geodate = \Carbon\Carbon::createFromTimestamp($position->timestamp/1000)->toDateTimeString();
        $clockInTimeStamp = null;
        if(isset($data['clockInTimestamp'])&&$data['clockInTimestamp']!='null'){
            $clockInTimeStamp = \Carbon\Carbon::createFromFormat('D M d Y H:i:s e+',$data['clockInTimestamp'])->toDateTimeString();
        }
        $clockOutTimeStamp = null;
        if(isset($data['clockOutTimestamp'])&&$data['clockOutTimestamp']!='null'){
            $clockOutTimeStamp = \Carbon\Carbon::createFromFormat('D M d Y H:i:s e+',$data['clockOutTimestamp'])->toDateTimeString();
        }
        $input_arr = [
            'user_id' => $user_id,
            'lat' => $position->coords['latitude'],
            'long' =>$position->coords['longitude'],
            'accuracy' => $position->coords['accuracy'],
            'mocked' => $position->mocked,
            'geotimestamp'=> $geodate,
            'address' => '',
            'clock_type'=>1,
            'img_url' => $data['photo'],
        ];
        if(isset($data['clockInTimestamp'])&&$data['clockInTimestamp']!='null'){
            $input_arr['clock_in'] = $clockInTimeStamp;
        }
        if(isset($data['clockOutTimestamp'])&&$data['clockOutTimestamp']!='null'){
            $input_arr['clock_out'] = $clockOutTimeStamp;
        }
        if(isset($data['start_battery'])){
            $input_arr['start_battery'] = $data['start_battery'];
        }
        if(isset($data['end_battery'])){
            $input_arr['end_battery'] = $data['end_battery'];
        }
            // store the file and set it's path to the value of the key holding it

        if($this->ClockInExists($data)){
            $updateModel = $this->model
            ->where('user_id', $user_id)
            ->whereDate('clock_in', Carbon::today())->first();
        
            $updateModel->clock_out= $clockOutTimeStamp;
            $updateModel->img_url= $data['photo'];
            $model = tap($updateModel)->save();
            return $model;
        }

        $ClockIn = $this->model::create($input_arr);

        $input_arr_copy = $input_arr;
        if($ClockIn){
            return $ClockIn;
        }
        throw new \Exception('An error occured attempting to create ClockIn');
        }
        public function ClockInExists() : bool
        {
            $user_id = Auth::guard('api')->user()->id;
            $exists = $this->model
                ->where('user_id', $user_id)
                ->whereDate('clock_in', Carbon::today())
                ->count() > 0;
            return $exists;
        }
        public function find($id) : ClockIn
        {
            return $this->model->find($id);
        }
}

<?php

namespace App\Repositories\Backend;

use App\Exceptions\GeneralException;
use App\Models\UserDeviceImei;
use App\Models\UserDeviceInfo;
use App\Repositories\BaseRepository;
use Auth;
use Carbon\Carbon;
use DB;

/**
 * Class UserDeviceInfoRepository
 * @package App\Repositories\Backend
 * @version March 1, 2020, 3:21 pm EAT
*/

class UserDeviceInfoRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'make',
        'android_id',
        'available_location_providers',
        'battery_level',
        'api_level',
        'brand',
        'is_camera_present',
        'device_id',
        'version',
        'active',
        'location_enabled',
        'timestamp'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function __construct(UserDeviceInfo $model)
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
    public function create(array $data) : UserDeviceInfo
    {
        \Log::debug($data);
        $structure_id = Auth::guard('api')->user()->logged_structure_id;
        if($structure_id==null){
            $structure_id = Auth::guard('api')->user()->structure_id;
        }
        $user_id = Auth::guard('api')->user()->id;
        $data['user_id'] = $user_id;
        $data['timestamp'] = \Carbon\Carbon::createFromTimestamp($data['timestamp']/1000)->toDateTimeString();
        // Make sure it doesn't already exist
        if ($this->UserDeviceInfoExists($data)) {

            $model = $this->model
                ->where('user_id', strtolower($data['user_id']))
                ->whereDate('created_at', Carbon::today())
                ->with('imei')
                ->whereHas('imei', function ($query) use ($data){
                    $query->whereIn('imei', $data['imeiList']);
                })
                ->first();

            $model->battery_level = $data['battery_level'];
            $model->apiLevel = $data['apiLevel'];
            $model->devicename = $data['devicename'];
            $model->readable_version = $data['readable_version'];
            $model->timestamp = $data['timestamp'];

            return tap($model)->save();
        }

        return DB::transaction(function () use ($data) {
            $imeis = $data['imeiList'];
            unset($data['imeiList']);
            unset($data['structures']);

            $UserDeviceInfo = $this->model::create($data);

            if ($UserDeviceInfo) {
                foreach($imeis as $imei){
                    if($imei){
                        UserDeviceImei::create([
                            "user_device_info_id" => $UserDeviceInfo->id,
                            "imei" => $imei,
                            "active" => true
                        ]);
                    }
                }
                return $UserDeviceInfo;
            }

            throw abort(422, 'An error occured attempting to create UserDeviceInfo');
        });
        }
        protected function UserDeviceInfoExists($data) : bool
        {
            $exists = $this->model
                ->where('user_id', strtolower($data['user_id']))
                ->whereDate('created_at', Carbon::today())
                ->with('imei')
                ->whereHas('imei', function ($query) use ($data){
                    $query->whereIn('imei', $data['imeiList']);
                })
                ->count() > 0;

            return $exists;
        }
        public function find($id) : UserDeviceInfo
        {
            return $this->model->find($id);
        }
}

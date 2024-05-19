<?php

namespace App\Models;

use App\Models\Auth\User;
use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class UserDeviceInfo
 * @package App\Models
 * @version March 1, 2020, 3:21 pm EAT
 *
 * @property \App\Models\User user
 * @property integer user_id
 * @property string make
 * @property string android_id
 * @property string available_location_providers
 * @property string battery_level
 * @property string api_level
 * @property string brand
 * @property string is_camera_present
 * @property string device_id
 * @property string version
 * @property boolean active
 * @property string location_enabled
 */
class UserDeviceInfo extends Model
{
    use SoftDeletes;

    public $table = 'user_device_info';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];

    protected $fillable = [
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
        'appVersion',
        'timestamp',
        'android_version',
        'devicename',
        'apiLevel',
        'appName',
        'readable_version'
    ];

    public $guarded = [
        'id',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'make' => 'string',
        'android_id' => 'string',
        'available_location_providers' => 'string',
        'battery_level' => 'string',
        'api_level' => 'string',
        'brand' => 'string',
        'is_camera_present' => 'string',
        'device_id' => 'string',
        'version' => 'string',
        'active' => 'boolean',
        'location_enabled' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function imei()
    {
        return $this->hasMany(UserDeviceImei::class, 'user_device_info_id');
    }
    public function clockins()
    {
        return $this->hasOne(ClockIn::class, 'user_id', 'user_id')->orderBy('created_at', 'DESC');;
    }
    public function locations()
    {
        return $this->hasMany(UserLocationHistory::class, 'user_id', 'user_id')->orderBy('created_at', 'DESC')->limit(5);
    }
}

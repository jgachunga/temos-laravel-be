<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class UserDeviceImei
 * @package App\Models
 * @version March 2, 2020, 9:55 pm EAT
 *
 * @property \App\Models\UserDeviceInfo userDeviceInfo
 * @property integer user_device_info_id
 * @property string imei
 * @property string device_id
 * @property boolean active
 */
class UserDeviceImei extends Model
{
    use SoftDeletes;

    public $table = 'user_device_imeis';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'user_device_info_id',
        'imei',
        'device_id',
        'active'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_device_info_id' => 'integer',
        'imei' => 'string',
        'device_id' => 'string',
        'active' => 'boolean'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_device_info_id' => 'required',
        'imei' => 'required',
        'active' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function userDeviceInfo()
    {
        return $this->belongsTo(\App\Models\UserDeviceInfo::class, 'user_device_info_id');
    }
}

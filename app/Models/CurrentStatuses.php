<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class CurrentStatuses
 * @package App\Models
 * @version February 23, 2020, 7:18 pm EAT
 *
 * @property \Illuminate\Database\Eloquent\Collection outletVisits
 * @property \Illuminate\Database\Eloquent\Collection userLocationHistories
 * @property \Illuminate\Database\Eloquent\Collection userStatuses
 * @property string name
 * @property string desc
 */
class CurrentStatuses extends Model
{
    use SoftDeletes;

    public $table = 'current_statuses';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'desc'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'desc' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function outletVisits()
    {
        return $this->hasMany(\App\Models\OutletVisit::class, 'current_status_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function userLocationHistories()
    {
        return $this->hasMany(\App\Models\UserLocationHistory::class, 'current_status_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function userStatuses()
    {
        return $this->hasMany(\App\Models\UserStatus::class, 'current_status_id');
    }
}

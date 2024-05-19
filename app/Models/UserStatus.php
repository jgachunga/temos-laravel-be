<?php

namespace App\Models;

use App\Models\Auth\User;
use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class UserStatus
 * @package App\Models
 * @version February 23, 2020, 7:19 pm EAT
 *
 * @property \App\Models\CurrentStatus currentStatus
 * @property \App\Models\Customer customer
 * @property \App\Models\Form form
 * @property \App\Models\User user
 * @property integer user_id
 * @property integer form_id
 * @property integer customer_id
 * @property integer current_status_id
 * @property string|\Carbon\Carbon last_seen
 * @property number lat
 * @property number long
 * @property number accuracy
 * @property boolean mocked
 * @property string|\Carbon\Carbon geotimestamp
 */
class UserStatus extends Model
{
    use SoftDeletes;

    public $table = 'user_statuses';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'user_id',
        'form_id',
        'customer_id',
        'current_status_id',
        'last_seen',
        'lat',
        'long',
        'accuracy',
        'mocked',
        'geotimestamp',
        'address'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'form_id' => 'integer',
        'customer_id' => 'integer',
        'current_status_id' => 'integer',
        'last_seen' => 'datetime',
        'lat' => 'float',
        'long' => 'float',
        'accuracy' => 'float',
        'mocked' => 'boolean',
        'geotimestamp' => 'datetime'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_id' => 'required',
        'mocked' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function currentStatus()
    {
        return $this->belongsTo(CurrentStatuses::class, 'current_status_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function customer()
    {
        return $this->belongsTo(\App\Models\Customer::class, 'customer_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function form()
    {
        return $this->belongsTo(\App\Models\Form::class, 'form_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

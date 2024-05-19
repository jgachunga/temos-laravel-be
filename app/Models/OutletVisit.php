<?php

namespace App\Models;

use App\Models\Auth\User;
use App\Scopes\StructureScope;
use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class OutletVisit
 * @package App\Models
 * @version February 23, 2020, 7:21 pm EAT
 *
 * @property \App\Models\CurrentStatus currentStatus
 * @property \App\Models\Customer customer
 * @property \App\Models\Form form
 * @property \App\Models\FormStatus status
 * @property \App\Models\User user
 * @property integer user_id
 * @property integer form_id
 * @property integer customer_id
 * @property integer current_status_id
 * @property integer status_id
 * @property string status
 * @property string reason
 * @property string other_reasons
 * @property boolean has_answers
 * @property string|\Carbon\Carbon timestamp
 * @property string|\Carbon\Carbon started_timestamp
 * @property number lat
 * @property number long
 * @property number accuracy
 * @property boolean mocked
 * @property string|\Carbon\Carbon geotimestamp
 */
class OutletVisit extends Model
{
    use SoftDeletes;

    public $table = 'outlet_visits';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];

    public $guarded = [];

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
        'status_id' => 'integer',
        'status' => 'string',
        'reason' => 'string',
        'other_reasons' => 'string',
        'has_answers' => 'boolean',
        'timestamp' => 'datetime',
        'started_timestamp' => 'datetime',
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
    ];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function currentStatus()
    {
        return $this->belongsTo(\App\Models\CurrentStatuses::class, 'current_status_id');
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
    public function status()
    {
        return $this->belongsTo(\App\Models\FormStatus::class, 'status_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

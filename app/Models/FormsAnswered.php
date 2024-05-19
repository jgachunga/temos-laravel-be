<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class FormsAnswered
 * @package App\Models
 * @version February 19, 2020, 2:12 pm UTC
 *
 * @property \App\Models\Customer customer
 * @property \App\Models\Form form
 * @property \App\Models\FormStatus status
 * @property \App\Models\User user
 * @property \Illuminate\Database\Eloquent\Collection formAnswers
 * @property integer form_id
 * @property integer user_id
 * @property integer customer_id
 * @property integer status_id
 * @property string status
 * @property string reason
 * @property string other_reasons
 * @property boolean has_answers
 * @property string|\Carbon\Carbon start
 * @property string|\Carbon\Carbon end
 * @property string|\Carbon\Carbon duration
 * @property number lat
 * @property number long
 * @property number accuracy
 * @property number latitude
 * @property boolean mocked
 * @property string|\Carbon\Carbon geotimestamp
 */
class FormsAnswered extends Model
{
    use SoftDeletes;

    public $table = 'forms_answered';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'form_id',
        'user_id',
        'customer_id',
        'c_detail_uuid',
        'stockist_id',
        'sub_customer_id',
        'status_id',
        'status',
        'reason',
        'other_reasons',
        'has_answers',
        'start',
        'end',
        'duration',
        'lat',
        'long',
        'accuracy',
        'latitude',
        'mocked',
        'geotimestamp'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'form_id' => 'integer',
        'user_id' => 'integer',
        'customer_id' => 'integer',
        'status_id' => 'integer',
        'status' => 'string',
        'reason' => 'string',
        'other_reasons' => 'string',
        'has_answers' => 'boolean',
        'start' => 'datetime',
        'end' => 'datetime',
        'duration' => 'string',
        'lat' => 'float',
        'long' => 'float',
        'accuracy' => 'float',
        'latitude' => 'float',
        'mocked' => 'boolean',
        'geotimestamp' => 'datetime'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'form_id' => 'required',
        'user_id' => 'required',
        'customer_id' => 'required',
        'status_id' => 'required',
        'has_answers' => 'required',
        'mocked' => 'required'
    ];

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
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function formAnswers()
    {
        return $this->hasMany(\App\Models\FormAnswer::class, 'form_answered_id');
    }
    public function customerDetail()
    {
        return $this->belongsTo(\App\Models\CustomerDetail::class, 'c_detail_uuid');
    }
}

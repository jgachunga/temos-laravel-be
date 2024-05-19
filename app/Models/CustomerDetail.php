<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class CustomerDetail
 * @package App\Models
 * @version January 22, 2023, 9:01 pm UTC
 *
 * @property integer $user_id
 * @property integer $customer_id
 * @property string|\Carbon\Carbon $started
 * @property string|\Carbon\Carbon $ended
 * @property string|\Carbon\Carbon $activeDate
 * @property string $category
 * @property string $status
 */
class CustomerDetail extends Model
{
    use SoftDeletes;

    public $table = 'customer_survey_details';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'user_id',
        'customer_id',
        'c_detail_uuid',
        'customer_uuid',
        'started',
        'ended',
        'activeDate',
        'category',
        'status',
        'reason',
        'sales',
        'orders',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'customer_id' => 'integer',
        'started' => 'datetime',
        'ended' => 'datetime',
        'activeDate' => 'datetime',
        'category' => 'string',
        'status' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_id' => 'nullable',
        'customer_id' => 'nullable|integer',
        'started' => 'nullable',
        'ended' => 'nullable',
        'activeDate' => 'nullable',
        'category' => 'nullable|string|max:191',
        'status' => 'nullable|string|max:191',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];


}

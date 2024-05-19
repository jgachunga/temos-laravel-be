<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class UserTarget
 * @package App\Models
 * @version March 13, 2020, 10:06 am EAT
 *
 * @property \App\Models\User createBy
 * @property \App\Models\SaleStructure structure
 * @property \App\Models\User user
 * @property integer user_id
 * @property string start_date
 * @property string end_date
 * @property boolean active
 * @property integer create_by
 * @property integer structure_id
 */
class UserTarget extends Model
{
    use SoftDeletes;

    public $table = 'user_targets';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'user_id',
        'start_date',
        'end_date',
        'active',
        'create_by',
        'structure_id',
        'target',
        'lppc',
        'strike_rate',
        'coverage'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'start_date' => 'date',
        'end_date' => 'date',
        'active' => 'boolean',
        'create_by' => 'integer',
        'structure_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'target' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function createBy()
    {
        return $this->belongsTo(\App\Models\User::class, 'create_by');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function structure()
    {
        return $this->belongsTo(\App\Models\SaleStructure::class, 'structure_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(\App\Models\Auth\User::class, 'user_id');
    }
}

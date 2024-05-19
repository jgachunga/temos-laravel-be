<?php

namespace App\Models;

use App\Models\Auth\User;
use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class SaleUnitTarget
 * @package App\Models
 * @version March 13, 2020, 10:06 am EAT
 *
 * @property \App\Models\User createBy
 * @property \App\Models\SaleStructure structure
 * @property integer structure_id
 * @property string start_date
 * @property string end_date
 * @property boolean active
 * @property integer create_by
 */
class SaleUnitTarget extends Model
{
    use SoftDeletes;

    public $table = 'sale_unit_targets';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'structure_id',
        'start_date',
        'end_date',
        'active',
        'target',
        'create_by'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'structure_id' => 'integer',
        'start_date' => 'date',
        'end_date' => 'date',
        'active' => 'boolean',
        'create_by' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'structure_id' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function createBy()
    {
        return $this->belongsTo(User::class, 'create_by');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function structure()
    {
        return $this->belongsTo(\App\Models\SaleStructure::class, 'structure_id');
    }
}

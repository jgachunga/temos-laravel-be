<?php

namespace App\Models;

use App\Models\Auth\User;
use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Teams
 * @package App\Models
 * @version February 29, 2020, 10:54 am EAT
 *
 * @property \App\Models\SaleStructure structure
 * @property \App\Models\User supervisor
 * @property integer supervisor_id
 * @property string name
 * @property integer structure_id
 */
class Teams extends Model
{
    use SoftDeletes;

    public $table = 'teams';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'supervisor_id',
        'name',
        'structure_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'supervisor_id' => 'integer',
        'name' => 'string',
        'structure_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'supervisor_id' => 'required',
        'name' => 'required'
    ];

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
    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }
}

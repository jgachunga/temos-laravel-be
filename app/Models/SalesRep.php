<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class SalesRep
 * @package App\Models
 * @version September 22, 2019, 5:52 am UTC
 *
 * @property integer user_id
 * @property integer dist_id
 * @property string name
 * @property string description
 */
class SalesRep extends Model
{
    use SoftDeletes;

    public $table = 'sales_reps';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'user_id',
        'dist_id',
        'name',
        'description',
        'structure_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'dist_id' => 'integer',
        'name' => 'string',
        'description' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_id' => 'required',
        'name' => 'required'
    ];

    
}

<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Type
 * @package App\Models
 * @version February 13, 2020, 10:25 am UTC
 *
 * @property string name
 * @property string desc
 */
class Type extends Model
{
    use SoftDeletes;

    public $table = 'types';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'desc',
        'structure_id'
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


}

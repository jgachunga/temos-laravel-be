<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Distributor
 * @package App\Models
 * @version September 22, 2019, 5:23 am UTC
 *
 * @property string name
 * @property string description
 */
class Distributor extends Model
{
    use SoftDeletes;

    public $table = 'distributors';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'description',
        'user_id',
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
        'description' => 'string',
        'user_id' => 'integer',
        'structure_id' => 'inreger'
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

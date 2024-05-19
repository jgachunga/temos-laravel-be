<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Version
 * @package App\Models
 * @version February 18, 2020, 6:47 pm UTC
 *
 * @property string name
 * @property string code
 * @property boolean active
 */
class Version extends Model
{
    use SoftDeletes;

    public $table = 'versions';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'code',
        'active'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'code' => 'string',
        'active' => 'boolean'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'code' => 'active boolean text'
    ];

    
}

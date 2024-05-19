<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PaymentMethods
 * @package App\Models
 * @version October 26, 2019, 3:44 am UTC
 *
 * @property string name
 * @property string img_url
 */
class PaymentMethods extends Model
{
    use SoftDeletes;

    public $table = 'payment_methods';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'img_url'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'img_url' => 'string'
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

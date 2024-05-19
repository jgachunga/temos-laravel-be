<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class OrderDetail
 * @package App\Models
 * @version October 28, 2019, 9:53 am UTC
 *
 * @property integer order_id
 * @property string product_code
 * @property string quantity
 * @property string sku
 * @property string price
 * @property string price_from
 * @property string total
 */
class OrderDetail extends Model
{
    use SoftDeletes;

    public $table = 'order_details';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'order_id',
        'product_code',
        'quantity',
        'sku',
        'price',
        'price_from',
        'total',
        'uom_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'order_id' => 'integer',
        'product_code' => 'string',
        'quantity' => 'string',
        'sku' => 'string',
        'price' => 'string',
        'price_from' => 'string',
        'total' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'order_id' => 'required',
        'product_code' => 'required',
        'quantity' => 'required',
        'total' => 'required'
    ];

    public function order() {
        return $this->hasOne('App\Models\Order');
    }
    public function product() {
        return $this->hasOne('App\Models\Product','id','product_code');
    }

}

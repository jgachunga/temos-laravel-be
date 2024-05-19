<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Order
 * @package App\Models
 * @version October 28, 2019, 9:48 am UTC
 *
 * @property integer structure_id
 * @property integer order_ref
 * @property string pax
 * @property string total_amount
 * @property string discount
 * @property string amount_payable
 * @property integer customer_id
 * @property integer opened_by
 * @property integer closed_by
 * @property string|\Carbon\Carbon closed_at
 * @property integer terminal_id
 * @property integer shift_id
 * @property boolean is_printed
 * @property boolean is_active
 * @property boolean is_shown
 * @property boolean is_closed
 * @property boolean is_void
 * @property string display_name
 */
class Order extends Model
{
    use SoftDeletes;

    public $table = 'orders';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];

    public $guarded =[];
    public $fillable = [
        'structure_id',
        'order_ref',
        'pax',
        'total_amount',
        'discount',
        'amount_payable',
        'customer_id',
        'opened_by',
        'closed_by',
        'closed_at',
        'terminal_id',
        'shift_id',
        'lat',
        'lng',
        'is_printed',
        'is_active',
        'is_shown',
        'is_closed',
        'is_void',
        'display_name',
        'user_id',
        'mocked',
        'accuracy',
        'loctimestamp',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'structure_id' => 'integer',
        'order_ref' => 'integer',
        'pax' => 'string',
        'total_amount' => 'string',
        'discount' => 'string',
        'amount_payable' => 'string',
        'customer_id' => 'integer',
        'opened_by' => 'integer',
        'closed_by' => 'integer',
        'closed_at' => 'datetime',
        'terminal_id' => 'integer',
        'shift_id' => 'integer',
        'is_printed' => 'boolean',
        'is_active' => 'boolean',
        'is_shown' => 'boolean',
        'is_closed' => 'boolean',
        'is_void' => 'boolean',
        'display_name' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'total_amount' => 'required',
        'customer_id' => 'required',
        'opened_by' => 'required',
        'terminal_id' => 'required',
        'shift_id' => 'required',
        'is_printed' => 'required',
        'is_active' => 'required',
        'is_shown' => 'required',
        'is_closed' => 'required',
        'is_void' => 'required'
    ];

    public function structure() {
        return $this->hasOne('App\Models\SaleStructure', 'id', 'structure_id');
    }
    public function customer() {
        return $this->hasOne('App\Models\Customer', 'id', 'customer_id');
    }
    public function items() {
        return $this->hasMany('App\Models\OrderDetail','order_id','id');
    }
}

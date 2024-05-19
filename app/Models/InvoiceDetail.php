<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class InvoiceDetail
 * @package App\Models
 * @version March 6, 2020, 10:32 am EAT
 *
 * @property \App\Models\Invoice invoice
 * @property \App\Models\Product product
 * @property integer invoice_id
 * @property integer product_id
 * @property string product_code
 * @property string price
 * @property string quantity
 * @property string taxes
 * @property string total_amount
 */
class InvoiceDetail extends Model
{
    use SoftDeletes;

    public $table = 'invoice_details';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'invoice_id',
        'product_id',
        'product_code',
        'price',
        'quantity',
        'taxes',
        'total_amount'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'invoice_id' => 'integer',
        'product_id' => 'integer',
        'product_code' => 'string',
        'price' => 'string',
        'quantity' => 'string',
        'taxes' => 'string',
        'total_amount' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'invoice_id' => 'required',
        'product_id' => 'required',
        'quantity' => 'required',
        'taxes' => 'required',
        'total_amount' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function invoice()
    {
        return $this->belongsTo(\App\Models\Invoice::class, 'invoice_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function product()
    {
        return $this->belongsTo(\App\Models\Product::class, 'product_id');
    }
}

<?php

namespace App\Models;

use App\Scopes\StructureScope;
use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Invoice
 * @package App\Models
 * @version March 6, 2020, 10:32 am EAT
 *
 * @property \App\Models\SaleStructure structure
 * @property \Illuminate\Database\Eloquent\Collection invoiceDetails
 * @property string ref
 * @property string business_code
 * @property string sub_total
 * @property string discount
 * @property string total_tax
 * @property string grand_total
 * @property string|\Carbon\Carbon date_due
 * @property boolean is_approved
 * @property integer created_by
 * @property integer customer_id
 * @property integer approved_by
 * @property integer updated_by
 * @property string payment_details
 * @property string terms
 * @property string footer
 * @property integer structure_id
 */
class Invoice extends Model
{
    use SoftDeletes;

    protected $primaryKey   = 'id';

    public $table = 'invoices';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'ref',
        'business_code',
        'sub_total',
        'discount',
        'c_detail_uuid',
        'total_tax',
        'grand_total',
        'date_due',
        'is_approved',
        'created_by',
        'customer_id',
        'approved_by',
        'invoice_id',
        'stockist_id',
        'updated_by',
        'payment_details',
        'terms',
        'footer',
        'structure_id',
        'sub_customer_id',
        'user_id',
        'lat',
        'lng',
        'loctimestamp',
        'mocked',
        'payment_method_id',
        'accuracy',
        'timestamp',
        'raise_order',
        'is_order_expired',
        'invoice_uuid',
        'option_uuid',
        'order_id',
        'invoice_date',
        'photo',
        'raise_stock'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'ref' => 'string',
        'business_code' => 'string',
        'sub_total' => 'string',
        'discount' => 'string',
        'total_tax' => 'string',
        'grand_total' => 'string',
        'date_due' => 'datetime',
        'is_approved' => 'boolean',
        'created_by' => 'integer',
        'customer_id' => 'integer',
        'approved_by' => 'integer',
        'updated_by' => 'integer',
        'payment_details' => 'string',
        'terms' => 'string',
        'footer' => 'string',
        'structure_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new StructureScope);
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function structure()
    {
        return $this->belongsTo(\App\Models\SaleStructure::class, 'structure_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function invoiceDetails()
    {
        return $this->hasMany(\App\Models\InvoiceDetail::class, 'invoice_id');
    }
    public function items()
    {
        return $this->hasMany(\App\Models\InvoiceDetail::class, 'invoice_id');
    }
    public function customer() {
        return $this->hasOne('App\Models\Customer', 'id', 'customer_id');
    }
    public function stockist() {
        return $this->hasOne('App\Models\Stockist', 'id', 'stockist_id');
    }
    public function user() {
        return $this->hasOne(\App\Models\Auth\User::class, 'id', 'user_id');
    }
    public function payment_method() {
        return $this->hasOne('App\Models\PaymentMethods', 'id', 'payment_method_id');
    }
    public function customerDetail()
    {
        return $this->belongsTo(\App\Models\CustomerDetail::class, 'c_detail_uuid');
    }
}

<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class CustomerSaleStructrure
 * @package App\Models
 * @version October 26, 2019, 6:23 pm UTC
 *
 * @property integer cust_id
 * @property integer structure_id
 */
class CustomerSaleStructrure extends Model
{
    use SoftDeletes;

    public $table = 'customer_sale_structrures';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'cust_id',
        'structure_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'cust_id' => 'integer',
        'structure_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    public function structure() {
        return $this->hasOne('App\Models\SaleStructure', 'id', 'structure_id');
    }
    public function customer() {
        return $this->hasOne('App\Models\Customer', 'id', 'cust_id');
    }
    
}

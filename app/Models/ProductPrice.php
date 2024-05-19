<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductPrice extends Model
{
    use SoftDeletes;
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'product_id',
        'channel_id',
        'price',
        'purchase_price',
        'selling_price'
    ];
    public function channel() {
        return $this->hasOne('App\Models\Channel','id','channel_id') ;
    }
}

<?php

namespace App\Models;

use App\Scopes\StructureScope;
use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Product
 * @package App\Models
 * @version September 24, 2019, 12:04 pm UTC
 *
 * @property string name
 * @property string code
 * @property string desc
 * @property integer cat_id
 * @property number price
 * @property string img_url
 * @property integer client_id
 * @property number discount
 */
class Product extends Model
{
    use SoftDeletes;

    public $table = 'products';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];

    public $guarded = [
        'id'
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
        'desc' => 'string',
        'cat_id' => 'integer',
        'price' => 'float',
        'img_url' => 'string',
        'client_id' => 'integer',
        'discount' => 'float'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|unique:products,name',
    ];
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new StructureScope);
    }
    public function prices() {
        return $this->hasMany('App\Models\ProductPrice','product_id','id') ;
    }
}

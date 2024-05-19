<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Uom
 * @package App\Models
 * @version March 16, 2020, 1:42 am EAT
 *
 * @property \Illuminate\Database\Eloquent\Collection orderDetails
 * @property string name
 * @property integer carton_pieces
 * @property number carton_price
 */
class Uom extends Model
{
    use SoftDeletes;

    public $table = 'uoms';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'carton_pieces',
        'carton_price'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'carton_pieces' => 'integer',
        'carton_price' => 'float'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function orderDetails()
    {
        return $this->hasMany(\App\Models\OrderDetail::class, 'uom_id');
    }
}

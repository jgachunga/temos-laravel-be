<?php

namespace App\Models;

use App\Scopes\StructureScope;
use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * Class Customer
 * @package App\Models
 * @version October 26, 2019, 5:06 am UTC
 *
 * @property integer user_id
 * @property integer rep_id
 * @property integer reg_by_rep_id
 * @property string name
 * @property string phone
 * @property string description
 * @property string lat
 * @property string lng
 * @property string accuracy
 */
class Customer extends Model
{
    use SoftDeletes;

    public $table = 'customers';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];

    protected $guarded = ['id'];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'rep_id' => 'integer',
        'reg_by_rep_id' => 'integer',
        'name' => 'string',
        'phone' => 'string',
        'description' => 'string',
        'lat' => 'string',
        'lng' => 'string',
        'accuracy' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'channel' => 'required',
    ];
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new StructureScope);
    }

    public function channel()
    {
        return $this->hasOne(\App\Models\Channel::class, 'id', 'channel_id');
    }
    public function town()
    {
        return $this->hasOne(\App\Models\Town::class, 'id', 'town_id');
    }
    public function sub_customers()
    {
        return $this->hasMany(\App\Models\SubCustomer::class, 'customer_id', 'id');
    }
    public function route()
    {
        return $this->belongsTo(\App\Models\Route::class, 'route_id', 'id');
    }
}

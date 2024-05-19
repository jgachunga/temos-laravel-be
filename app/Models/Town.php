<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Town
 * @package App\Models
 * @version March 6, 2020, 10:04 am EAT
 *
 * @property \App\Models\Route route
 * @property \Illuminate\Database\Eloquent\Collection stockists
 * @property integer route_id
 * @property string name
 * @property string desc
 */
class Town extends Model
{
    use SoftDeletes;

    public $table = 'towns';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'route_id',
        'name',
        'desc'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'route_id' => 'integer',
        'name' => 'string',
        'desc' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'route_id' => 'required',
        'name' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function route()
    {
        return $this->belongsTo(\App\Models\Route::class, 'route_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function stockists()
    {
        return $this->hasMany(\App\Models\Stockist::class, 'town_id');
    }
}

<?php

namespace App\Models;

use App\Scopes\StructureScope;
use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Region
 * @package App\Models
 * @version March 6, 2020, 10:03 am EAT
 *
 * @property \App\Models\Country country
 * @property \Illuminate\Database\Eloquent\Collection routes
 * @property integer country_id
 * @property string name
 * @property string desc
 */
class Region extends Model
{
    use SoftDeletes;

    public $table = 'regions';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'country_id',
        'name',
        'desc',
        'structure_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'country_id' => 'integer',
        'name' => 'string',
        'desc' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'country_id' => 'required',
        'name' => 'required'
    ];

    public static $update_rules = [

    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new StructureScope);
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function country()
    {
        return $this->belongsTo(\App\Models\Country::class, 'country_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function routes()
    {
        return $this->hasMany(\App\Models\Route::class, 'region_id');
    }
}

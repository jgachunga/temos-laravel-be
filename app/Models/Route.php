<?php

namespace App\Models;

use App\Scopes\StructureScope;
use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Route
 * @package App\Models
 * @version March 6, 2020, 10:03 am EAT
 *
 * @property \App\Models\Region region
 * @property \Illuminate\Database\Eloquent\Collection towns
 * @property integer region_id
 * @property string name
 * @property string desc
 */
class Route extends Model
{
    use SoftDeletes;

    public $table = 'routes';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'stockist_id',
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
        'stockist_id' => 'integer',
        'name' => 'string',
        'desc' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'stockist_id' => 'required',
        'name' => 'required'
    ];
    public static $update_rules = [
        'name' => 'required'
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new StructureScope);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function stockist()
    {
        return $this->belongsTo(\App\Models\Stockist::class, 'stockist_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function towns()
    {
        return $this->hasMany(\App\Models\Town::class, 'route_id');
    }
}

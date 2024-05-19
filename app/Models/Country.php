<?php

namespace App\Models;

use App\Scopes\StructureScope;
use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Country
 * @package App\Models
 * @version March 6, 2020, 10:02 am EAT
 *
 * @property \Illuminate\Database\Eloquent\Collection regions
 * @property string name
 * @property string desc
 */
class Country extends Model
{
    use SoftDeletes;

    public $table = 'countries';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
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
        'name' => 'string',
        'desc' => 'string'
    ];
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new StructureScope);
    }
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
    public function regions()
    {
        return $this->hasMany(\App\Models\Region::class, 'country_id');
    }
}

<?php

namespace App\Models;

use App\Scopes\StructureScope;
use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Area
 * @package App\Models
 * @version April 22, 2021, 8:54 pm UTC
 *
 * @property \App\Models\Region $region
 * @property \App\Models\SaleStructure $structure
 * @property integer $region_id
 * @property string $name
 * @property string $desc
 * @property integer $structure_id
 */
class Area extends Model
{
    use SoftDeletes;

    public $table = 'areas';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'region_id',
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
        'region_id' => 'integer',
        'name' => 'string',
        'desc' => 'string',
        'structure_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'region_id' => 'required',
        'name' => 'required|string|max:45',
        'desc' => 'nullable|string|max:75',
        'structure_id' => 'nullable|integer',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new StructureScope);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function region()
    {
        return $this->belongsTo(\App\Models\Region::class, 'region_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function structure()
    {
        return $this->belongsTo(\App\Models\SaleStructure::class, 'structure_id');
    }
}

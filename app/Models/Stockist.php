<?php

namespace App\Models;

use App\Scopes\StructureScope;
use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Stockist
 * @package App\Models
 * @version March 6, 2020, 10:04 am EAT
 *
 * @property \App\Models\Town town
 * @property integer town_id
 * @property string name
 * @property string desc
 */
class Stockist extends Model
{
    use SoftDeletes;

    public $table = 'stockists';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'area_id',
        'structure_id',
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
        'area_id' => 'integer',
        'name' => 'string',
        'desc' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'area_id' => 'required',
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
    public function area()
    {
        return $this->belongsTo(\App\Models\Area::class, 'area_id');
    }
}

<?php

namespace App\Models;

use App\Scopes\StructureScope;
use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Channel
 * @package App\Models
 * @version October 19, 2019, 6:49 am UTC
 *
 * @property string name
 * @property string desc
 */
class Channel extends Model
{
    use SoftDeletes;

    public $table = 'channels';


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

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new StructureScope);
    }

}

<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class FormCategory
 * @package App\Models
 * @version March 1, 2020, 10:42 am EAT
 *
 * @property string name
 */
class FormCategory extends Model
{
    use SoftDeletes;

    public $table = 'form_categories';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'structure_id',
        'active'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'active' => 'boolean'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];

    public function forms()
    {
        return $this->hasMany(\App\Models\Form::class, 'form_category_id');
    }
}

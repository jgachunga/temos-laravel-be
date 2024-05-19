<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class QuestionOption
 * @package App\Models
 * @version February 18, 2020, 10:09 am UTC
 *
 * @property string label
 * @property string value
 * @property boolean selected
 */
class QuestionOption extends Model
{
    use SoftDeletes;

    public $table = 'question_options';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'label',
        'value',
        'selected',
        'question_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'label' => 'string',
        'value' => 'string',
        'selected' => 'boolean'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];


}

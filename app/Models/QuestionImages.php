<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class QuestionImages
 * @package App\Models
 * @version February 22, 2020, 1:03 pm UTC
 *
 * @property \App\Models\Question question
 * @property integer question_id
 * @property string label
 * @property string value
 * @property boolean selected
 */
class QuestionImages extends Model
{
    use SoftDeletes;

    public $table = 'question_images';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $guarded = [
        'id',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'question_id' => 'integer',
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
        'question_id' => 'required',
        'label' => 'required',
        'value' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function question()
    {
        return $this->belongsTo(\App\Models\Question::class, 'question_id');
    }
}

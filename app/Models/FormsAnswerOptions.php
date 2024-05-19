<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class FormsAnswerOptions
 * @package App\Models
 * @version February 19, 2020, 2:14 pm UTC
 *
 * @property \App\Models\FormAnswer formAnswer
 * @property \App\Models\Question question
 * @property \App\Models\QuestionOption questionOption
 * @property integer form_answer_id
 * @property integer question_id
 * @property string question_type
 * @property integer question_option_id
 * @property string answer
 */
class FormsAnswerOptions extends Model
{
    use SoftDeletes;

    public $table = 'form_answer_options';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'form_answer_id',
        'question_id',
        'question_type',
        'question_option_id',
        'answer'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'form_answer_id' => 'integer',
        'question_id' => 'integer',
        'question_type' => 'string',
        'question_option_id' => 'integer',
        'answer' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'form_answer_id' => 'required',
        'question_id' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function formAnswer()
    {
        return $this->belongsTo(\App\Models\FormAnswer::class, 'form_answer_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function question()
    {
        return $this->belongsTo(\App\Models\Question::class, 'question_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function questionOption()
    {
        return $this->belongsTo(\App\Models\QuestionOption::class, 'question_option_id');
    }
}

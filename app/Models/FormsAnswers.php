<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class FormsAnswers
 * @package App\Models
 * @version February 19, 2020, 2:13 pm UTC
 *
 * @property \App\Models\FormsAnswered formAnswered
 * @property \App\Models\Question question
 * @property \Illuminate\Database\Eloquent\Collection formAnswerOptions
 * @property integer form_answered_id
 * @property integer question_id
 * @property string question_type
 * @property string answer
 * @property string target
 * @property string diff
 * @property string|\Carbon\Carbon answer_timestamp
 * @property string image_url
 */
class FormsAnswers extends Model
{
    use SoftDeletes;

    public $table = 'form_answers';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'form_answered_id',
        'question_id',
        'question_type',
        'answer',
        'target',
        'diff',
        'answer_timestamp',
        'image_url'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'form_answered_id' => 'integer',
        'question_id' => 'integer',
        'question_type' => 'string',
        'answer' => 'string',
        'target' => 'string',
        'diff' => 'string',
        'answer_timestamp' => 'datetime',
        'image_url' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'form_answered_id' => 'required',
        'question_id' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function formAnswered()
    {
        return $this->belongsTo(\App\Models\FormsAnswered::class, 'form_answered_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function question()
    {
        return $this->belongsTo(\App\Models\Question::class, 'question_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function formAnswerOptions()
    {
        return $this->hasMany(\App\Models\FormAnswerOption::class, 'form_answer_id');
    }
}

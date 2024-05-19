<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class SkipCondition
 * @package App\Models
 * @version July 24, 2021, 8:54 pm EAT
 *
 * @property \App\Models\Question $question
 * @property integer $question_id
 * @property string $label
 * @property string $value
 */
class SkipCondition extends Model
{
    use SoftDeletes;

    public $table = 'skip_conditions';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'question_id',
        'label',
        'value',
        'skip_option_id',
        'selected_question_id'
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
        'value' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'question_id' => 'required|integer',
        'label' => 'required|string|max:191',
        'value' => 'required|string|max:191',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function question()
    {
        return $this->belongsTo(\App\Models\Question::class, 'question_id');
    }
    public function questionselected()
    {
        return $this->hasOne(\App\Models\Question::class, 'id', 'selected_question_id');
    }
    public function option()
    {
        return $this->hasOne(\App\Models\SkipOption::class, 'id',  'skip_option_id');
    }
}

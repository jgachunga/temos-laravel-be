<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Question
 * @package App\Models
 * @version February 18, 2020, 10:00 am UTC
 *
 * @property string type
 * @property boolean required
 * @property string label
 */
class Question extends Model
{
    use SoftDeletes;

    public $table = 'questions';


    protected $dates = ['deleted_at'];


    public $guarded = [

    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'type' => 'string',
        'required' => 'boolean',
        'skip' => 'boolean',
        'label' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'type' => 'required',
        'required' => 'required',
        'label' => 'classname string text'
    ];

    public function values() {
        return $this->hasMany('App\Models\QuestionOption','question_id','id');
    }

    public function options()
    {
        return $this->hasMany(\App\Models\QuestionOption::class, 'question_id');
    }
    public function skip_conditions()
    {
        return $this->hasMany(\App\Models\SkipCondition::class, 'question_id');
    }
}

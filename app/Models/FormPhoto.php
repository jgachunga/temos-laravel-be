<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class FormPhoto
 * @package App\Models
 * @version January 22, 2023, 9:02 pm UTC
 *
 * @property integer $form_answered_id
 * @property integer $question_id
 * @property string $image_url
 */
class FormPhoto extends Model
{
    use SoftDeletes;

    public $table = 'form_photos';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'form_answered_id',
        'question_id',
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
        'image_url' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'form_answered_id' => 'required',
        'question_id' => 'required|integer',
        'image_url' => 'nullable|string|max:191',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];

    
}

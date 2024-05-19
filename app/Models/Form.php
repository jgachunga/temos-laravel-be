<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Form
 * @package App\Models
 * @version December 2, 2019, 8:48 am UTC
 *
 * @property \App\Models\User user
 * @property \Illuminate\Database\Eloquent\Collection formSubmissions
 * @property integer user_id
 * @property string name
 * @property string visibility
 * @property boolean allows_edit
 * @property string identifier
 * @property string form_builder_json
 * @property string custom_submit_url
 */
class Form extends Model
{
    use SoftDeletes;

    public $table = 'forms';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'user_id',
        'name',
        'visibility',
        'allows_edit',
        'identifier',
        'form_builder_json',
        'custom_submit_url'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'name' => 'string',
        'visibility' => 'string',
        'allows_edit' => 'boolean',
        'identifier' => 'string',
        'form_builder_json' => 'string',
        'custom_submit_url' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        // 'name' => 'required',
        // 'visibility' => 'required',
        // 'allows_edit' => 'required',
        // 'identifier' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function formSubmissions()
    {
        return $this->hasMany(\App\Models\FormSubmission::class, 'form_id');
    }
    public function questions()
    {
        return $this->hasMany(\App\Models\Question::class, 'form_id');
    }
}

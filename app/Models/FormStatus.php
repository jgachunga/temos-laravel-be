<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class FormStatus
 * @package App\Models
 * @version February 19, 2020, 2:11 pm UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection formsAnswereds
 * @property string status
 * @property string desc
 */
class FormStatus extends Model
{
    use SoftDeletes;

    public $table = 'form_status';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'status',
        'desc'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'status' => 'string',
        'desc' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'status' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function formsAnswereds()
    {
        return $this->hasMany(\App\Models\FormsAnswered::class, 'status_id');
    }
}

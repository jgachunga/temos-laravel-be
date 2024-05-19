<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class UserRoute
 * @package App\Models
 * @version April 25, 2021, 7:49 pm UTC
 *
 * @property \App\Models\Route $route
 * @property \App\Models\User $user
 * @property integer $route_id
 * @property integer $user_id
 */
class UserRoute extends Model
{
    use SoftDeletes;

    public $table = 'user_routes';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'route_id',
        'user_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'route_id' => 'integer',
        'user_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'route_id' => 'required',
        'user_id' => 'required',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function route()
    {
        return $this->belongsTo(\App\Models\Route::class, 'route_id' ,'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(\App\Models\Auth\User::class, 'user_id');
    }
}

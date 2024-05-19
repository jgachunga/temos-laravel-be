<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class UserClient
 * @package App\Models
 * @version January 8, 2023, 11:13 am UTC
 *
 * @property integer $user_id
 * @property integer $structure_id
 */
class UserClient extends Model
{
    use SoftDeletes;

    public $table = 'user_clients';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'user_id',
        'structure_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'structure_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_id' => 'nullable',
        'structure_id' => 'nullable|integer',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];

    public function structure()
    {
        return $this->hasOne(\App\Models\SaleStructure::class, 'id', 'structure_id');
    }
}

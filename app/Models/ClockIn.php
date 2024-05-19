<?php

namespace App\Models;

use App\Models\Auth\User;
use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ClockIn
 * @package App\Models
 * @version February 24, 2020, 3:29 pm EAT
 *
 * @property integer user_id
 * @property integer clock_type
 * @property string img_url
 * @property string|\Carbon\Carbon clock_in
 * @property string|\Carbon\Carbon clock_out
 * @property number lat
 * @property number long
 * @property number accuracy
 * @property boolean mocked
 * @property string|\Carbon\Carbon geotimestamp
 * @property string address
 */
class ClockIn extends Model
{
    use SoftDeletes;

    public $table = 'clock_ins';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'user_id',
        'clock_type',
        'img_url',
        'clock_in',
        'clock_out',
        'lat',
        'long',
        'accuracy',
        'mocked',
        'geotimestamp',
        'address',
        'img_url',
        'start_battery',
        'end_battery'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'clock_type' => 'integer',
        'img_url' => 'string',
        'clock_in' => 'datetime',
        'clock_out' => 'datetime',
        'lat' => 'float',
        'long' => 'float',
        'accuracy' => 'float',
        'mocked' => 'boolean',
        'geotimestamp' => 'datetime',
        'address' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function clocktype()
    {
        return $this->belongsTo(ClockTypes::class, 'clock_type');
    }

}

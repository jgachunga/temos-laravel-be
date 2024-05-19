<?php

namespace App\Models;

use App\Scopes\StructureScope;
use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class SubCustomer
 * @package App\Models
 * @version April 25, 2021, 7:40 pm UTC
 *
 * @property \App\Models\Channel $channel
 * @property \App\Models\SalesRep $regByRep
 * @property \App\Models\SalesRep $rep
 * @property \App\Models\User $user
 * @property integer $user_id
 * @property integer $rep_id
 * @property integer $reg_by_rep_id
 * @property string $name
 * @property string $phone_number
 * @property string $email
 * @property string $first_name
 * @property string $last_name
 * @property integer $channel_id
 * @property boolean $mocked
 * @property string $gpstimestamp
 * @property string $description
 * @property number $lat
 * @property number $lng
 * @property string $accuracy
 * @property number $speed
 * @property string $heading
 */
class SubCustomer extends Model
{
    use SoftDeletes;

    public $table = 'sub_customers';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    protected $guarded = ['id'];
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'rep_id' => 'integer',
        'reg_by_rep_id' => 'integer',
        'name' => 'string',
        'phone_number' => 'string',
        'email' => 'string',
        'first_name' => 'string',
        'last_name' => 'string',
        'channel_id' => 'integer',
        'mocked' => 'boolean',
        'gpstimestamp' => 'string',
        'description' => 'string',
        'lat' => 'decimal:8',
        'lng' => 'decimal:8',
        'accuracy' => 'string',
        'speed' => 'decimal:4',
        'heading' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_id' => 'nullable',
        'rep_id' => 'nullable|integer',
        'reg_by_rep_id' => 'nullable|integer',
        'name' => 'required|string|max:191',
        'phone_number' => 'nullable|string|max:191',
        'email' => 'nullable|string|max:191',
        'first_name' => 'nullable|string|max:191',
        'last_name' => 'nullable|string|max:191',
        'channel_id' => 'nullable|integer',
        'mocked' => 'required|boolean',
        'gpstimestamp' => 'nullable|string|max:191',
        'description' => 'nullable|string|max:191',
        'lat' => 'nullable|numeric',
        'lng' => 'nullable|numeric',
        'accuracy' => 'nullable|string|max:50',
        'speed' => 'nullable|numeric',
        'heading' => 'nullable|string|max:30',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new StructureScope);
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function channel()
    {
        return $this->belongsTo(\App\Models\Channel::class, 'channel_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function regByRep()
    {
        return $this->belongsTo(\App\Models\SalesRep::class, 'reg_by_rep_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function rep()
    {
        return $this->belongsTo(\App\Models\SalesRep::class, 'rep_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
    public function customer()
    {
        return $this->belongsTo(\App\Models\Customer::class, 'customer_id');
    }
}

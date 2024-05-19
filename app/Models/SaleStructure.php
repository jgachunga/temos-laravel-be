<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class SaleStructure
 * @package App\Models
 * @version October 12, 2019, 9:29 am UTC
 *
 * @property string title
 * @property integer parent_id
 */
class SaleStructure extends Model
{
    use SoftDeletes;

    public $table = 'sale_structures';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'title',
        'parent_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'title' => 'string',
        'parent_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'title' => 'required'
    ];

    public function childs() {
        return $this->hasMany('App\Models\SaleStructure','parent_id','id') ;
    }
}

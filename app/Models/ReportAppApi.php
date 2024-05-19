<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ReportAppApi
 * @package App\Models
 * @version January 31, 2023, 1:26 am UTC
 *
 */
class ReportAppApi extends Model
{
    use SoftDeletes;

    public $table = 'report_app_apis';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}

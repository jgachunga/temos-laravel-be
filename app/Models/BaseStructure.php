<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Area
 * @package App\Models
 * @version April 22, 2021, 8:54 pm UTC
 *
 * @property \App\Models\Region $region
 * @property \App\Models\SaleStructure $structure
 * @property integer $region_id
 * @property string $name
 * @property string $desc
 * @property integer $structure_id
 */
class BaseStructure extends Model
{
    public function scopeStatus($query)
    {
        $structure_id = Auth::guard('api')->user()->logged_structure_id;
        if($structure_id==null){
          $structure_id = Auth::guard('api')->user()->structure_id;
        }
        dd($structure_id);
        return $query->where('structure_id', '=', $structure_id);
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function structure()
    {
        return $this->belongsTo(\App\Models\SaleStructure::class, 'structure_id');
    }
}

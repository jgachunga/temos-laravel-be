<?php

namespace App\Scopes;

use App\Helpers\StructureHelper;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class StructureScope implements Scope
{
    public $structureHelper;
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $structure_id = 1;
        if(!Auth::guard('api')->user()->is_rep){
            $structure_id = Auth::guard('api')->user()->logged_structure_id;
            if($structure_id==null){
            $structure_id = Auth::guard('api')->user()->structure_id;
            }
        }else{
            $structure_id = Auth::guard('api')->user()->structure_id;
        }
        $this->structureHelper = new StructureHelper;
        $structures =  $this->structureHelper->getChildren($structure_id);

        $builder->whereIn('structure_id', $structures);
    }
}

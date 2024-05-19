<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Helpers\StructureHelper;

class CheckStructure
{
    public $structureHelper;

    public function __construct(StructureHelper $structureHelper)
    {
        $this->structureHelper = $structureHelper;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!$request->get('structure_id')){
            $structure_id = Auth::guard('api')->user()->logged_structure_id;
            if($structure_id==null){
                $structure_id = Auth::guard('api')->user()->structure_id;
            }
            $request->merge(["structure_id"=>$structure_id]);
        }else{
            $structure_id = $request->get('structure_id');
        }
        $structures =  $this->structureHelper->getChildren($structure_id);

        $request->merge(["structures"=>$structures]);
        return $next($request);
    }
}

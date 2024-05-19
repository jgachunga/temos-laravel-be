<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\API\V1\CreateSaleStructureAPIRequest;
use App\Http\Requests\API\V1\UpdateSaleStructureAPIRequest;
use App\Models\SaleStructure;
use App\Models\CustomerSaleStructrure;
use App\Repositories\Backend\SaleStructureRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

use App\Helpers\StructureHelper;
use App\Models\Auth\User;
use Exception;
use Illuminate\Support\Facades\Auth;

/**
 * Class SaleStructureController
 * @package App\Http\Controllers\API\V1
 */

class SaleStructureAPIController extends AppBaseController
{
    /** @var  SaleStructureRepository */
    private $saleStructureRepository;
    public $structureHelper;

    public function __construct(SaleStructureRepository $saleStructureRepo, StructureHelper $structureHelper)
    {
        $this->saleStructureRepository = $saleStructureRepo;
        $this->structureHelper = $structureHelper;
    }

    /**
     * Display a listing of the SaleStructure.
     * GET|HEAD /saleStructures
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $saleStructures = $this->saleStructureRepository->list();

        return $this->sendResponse($saleStructures, 'Sale Structures retrieved successfully');
    }

    public function structuresList(Request $request)
    {
        $saleStructures = SaleStructure::where('parent_id', 1)->orderByDesc('created_at')->get();

        return $this->sendResponse($saleStructures->toArray(), 'Structures retrieved successfully');
    }
    /**
     * Store a newly created SaleStructure in storage.
     * POST /saleStructures
     *
     * @param CreateSaleStructureAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateSaleStructureAPIRequest $request)
    {
        $input=$request->json()->all();

        $saleStructure = $this->saleStructureRepository->create($input);

        return $this->sendResponse($saleStructure->toArray(), 'Sale Structure saved successfully');
    }

    /**
     * Display the specified SaleStructure.
     * GET|HEAD /saleStructures/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var SaleStructure $saleStructure */
        $saleStructure = $this->saleStructureRepository->find($id);

        if (empty($saleStructure)) {
            return $this->sendError('Sale Structure not found');
        }

        return $this->sendResponse($saleStructure->toArray(), 'Sale Structure retrieved successfully');
    }
    public function custStructures($id)
    {
        /** @var SaleStructure $saleStructure */
        if(Auth::guard('api')->user()->is_rep==1){
            $cust_id = $id;
        }else{
            $cust_id = Auth::guard('api')->user()->cust_id;
        }

        $selectedStructures = CustomerSaleStructrure::where("cust_id", $cust_id)->with('structure')->with('customer')->get();

        if (empty($selectedStructures)) {
            return $this->sendError('Sale Structure not found');
        }

        return $this->sendResponse($selectedStructures->toArray(), 'Sale Structure retrieved successfully');
    }

    /**
     * Update the specified SaleStructure in storage.
     * PUT/PATCH /saleStructures/{id}
     *
     * @param int $id
     * @param UpdateSaleStructureAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSaleStructureAPIRequest $request)
    {
        $input = $request->all();
        /** @var SaleStructure $saleStructure */
        $saleStructure = $this->saleStructureRepository->find($id);

        if (empty($saleStructure)) {
            return $this->sendError('Sale Structure not found');
        }

        $saleStructure = $this->saleStructureRepository->update($input, $id);

        return $this->sendResponse($saleStructure->toArray(), 'SaleStructure updated successfully');
    }

    /**
     * Remove the specified SaleStructure from storage.
     * DELETE /saleStructures/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var SaleStructure $saleStructure */
        $saleStructure = $this->saleStructureRepository->find($id);

        if (empty($saleStructure)) {
            return $this->sendError('Sale Structure not found');
        }

        $saleStructure->delete();

        return $this->sendResponse($id, 'Sale Structure deleted successfully');
    }
    public function listChilds($structure_id){
        return $this->structureHelper->getChildren($structure_id);
    }
    public function loginToUnit (Request $request){
        $structure_id = $request->get('structure_id');
        $user_id = Auth::guard('api')->user()->id;
        $user = User::findorfail($user_id);
        $user_update = tap($user)->update([
            'logged_structure_id' => $structure_id
        ]);
        return $this->sendResponse($user_update, 'Sale Structure login successful');
    }
    public function resetloginToUnit (Request $request){
        $user_id = Auth::guard('api')->user()->id;
        $user = User::findorfail($user_id);
        $user_update = tap($user)->update([
            'logged_structure_id' => null
        ]);
        return $this->sendResponse($user_update, 'Sale Structure login successful');
    }
}

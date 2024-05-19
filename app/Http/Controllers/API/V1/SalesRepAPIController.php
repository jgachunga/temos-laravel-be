<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\API\V1\CreateSalesRepAPIRequest;
use App\Http\Requests\API\V1\UpdateSalesRepAPIRequest;
use App\Models\SalesRep;
use App\Repositories\Backend\SalesRepRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Models\Auth\User;
use Response;

/**
 * Class SalesRepController
 * @package App\Http\Controllers\API\V1
 */

class SalesRepAPIController extends AppBaseController
{
    /** @var  SalesRepRepository */
    private $salesRepRepository;

    public function __construct(SalesRepRepository $salesRepRepo)
    {
        $this->salesRepRepository = $salesRepRepo;
    }

    /**
     * Display a listing of the SalesRep.
     * GET|HEAD /salesReps
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $salesReps = $this->salesRepRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($salesReps->toArray(), 'Sales Reps retrieved successfully');
    }

    public function users(Request $request){
        $structure_id = $request->get('structure_id');
        $users = User::where('structure_id', $structure_id)->with('roles')->get();
        return $this->sendResponse($users->toArray(), 'Users retrieved successfully');
    }

    /**
     * Store a newly created SalesRep in storage.
     * POST /salesReps
     *
     * @param CreateSalesRepAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateSalesRepAPIRequest $request)
    {
        $input = $request->all();

        $salesRep = $this->salesRepRepository->create($input);

        return $this->sendResponse($salesRep->toArray(), 'Sales Rep saved successfully');
    }

    /**
     * Display the specified SalesRep.
     * GET|HEAD /salesReps/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var SalesRep $salesRep */
        $salesRep = $this->salesRepRepository->find($id);

        if (empty($salesRep)) {
            return $this->sendError('Sales Rep not found');
        }

        return $this->sendResponse($salesRep->toArray(), 'Sales Rep retrieved successfully');
    }

    /**
     * Update the specified SalesRep in storage.
     * PUT/PATCH /salesReps/{id}
     *
     * @param int $id
     * @param UpdateSalesRepAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSalesRepAPIRequest $request)
    {
        $input = $request->except('structures');
        /** @var SalesRep $salesRep */
        $salesRep = $this->salesRepRepository->update($input, $id);

        return $this->sendResponse($salesRep->toArray(), 'SalesRep updated successfully');
    }

    /**
     * Remove the specified SalesRep from storage.
     * DELETE /salesReps/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var SalesRep $salesRep */
        $salesRep = $this->salesRepRepository->find($id);

        if (empty($salesRep)) {
            return $this->sendError('Sales Rep not found');
        }

        $salesRep->delete();

        return $this->sendResponse($id, 'Sales Rep deleted successfully');
    }
}

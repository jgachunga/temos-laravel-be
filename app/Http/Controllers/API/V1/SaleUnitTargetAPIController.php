<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\API\V1\CreateSaleUnitTargetAPIRequest;
use App\Http\Requests\API\V1\UpdateSaleUnitTargetAPIRequest;
use App\Models\SaleUnitTarget;
use App\Repositories\Backend\SaleUnitTargetRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class SaleUnitTargetController
 * @package App\Http\Controllers\API\V1
 */

class SaleUnitTargetAPIController extends AppBaseController
{
    /** @var  SaleUnitTargetRepository */
    private $saleUnitTargetRepository;

    public function __construct(SaleUnitTargetRepository $saleUnitTargetRepo)
    {
        $this->saleUnitTargetRepository = $saleUnitTargetRepo;
    }

    /**
     * Display a listing of the SaleUnitTarget.
     * GET|HEAD /saleUnitTargets
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $saleUnitTargets = $this->saleUnitTargetRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($saleUnitTargets->toArray(), 'Sale Unit Targets retrieved successfully');
    }

    /**
     * Store a newly created SaleUnitTarget in storage.
     * POST /saleUnitTargets
     *
     * @param CreateSaleUnitTargetAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateSaleUnitTargetAPIRequest $request)
    {
        $input = $request->all();

        $saleUnitTarget = $this->saleUnitTargetRepository->create($input);

        return $this->sendResponse($saleUnitTarget->toArray(), 'Sale Unit Target saved successfully');
    }

    /**
     * Display the specified SaleUnitTarget.
     * GET|HEAD /saleUnitTargets/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var SaleUnitTarget $saleUnitTarget */
        $saleUnitTarget = $this->saleUnitTargetRepository->find($id);

        if (empty($saleUnitTarget)) {
            return $this->sendError('Sale Unit Target not found');
        }

        return $this->sendResponse($saleUnitTarget->toArray(), 'Sale Unit Target retrieved successfully');
    }

    /**
     * Update the specified SaleUnitTarget in storage.
     * PUT/PATCH /saleUnitTargets/{id}
     *
     * @param int $id
     * @param UpdateSaleUnitTargetAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSaleUnitTargetAPIRequest $request)
    {
        $input = $request->all();

        /** @var SaleUnitTarget $saleUnitTarget */
        $saleUnitTarget = $this->saleUnitTargetRepository->find($id);

        if (empty($saleUnitTarget)) {
            return $this->sendError('Sale Unit Target not found');
        }

        $saleUnitTarget = $this->saleUnitTargetRepository->update($input, $id);

        return $this->sendResponse($saleUnitTarget->toArray(), 'SaleUnitTarget updated successfully');
    }

    /**
     * Remove the specified SaleUnitTarget from storage.
     * DELETE /saleUnitTargets/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var SaleUnitTarget $saleUnitTarget */
        $saleUnitTarget = $this->saleUnitTargetRepository->find($id);

        if (empty($saleUnitTarget)) {
            return $this->sendError('Sale Unit Target not found');
        }

        $saleUnitTarget->delete();

        return $this->sendResponse($id, 'Sale Unit Target deleted successfully');
    }
}

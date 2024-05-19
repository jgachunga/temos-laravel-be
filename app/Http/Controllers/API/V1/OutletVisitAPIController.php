<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\API\V1\CreateOutletVisitAPIRequest;
use App\Http\Requests\API\V1\UpdateOutletVisitAPIRequest;
use App\Models\OutletVisit;
use App\Repositories\Backend\OutletVisitRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class OutletVisitController
 * @package App\Http\Controllers\API\V1
 */

class OutletVisitAPIController extends AppBaseController
{
    /** @var  OutletVisitRepository */
    private $outletVisitRepository;

    public function __construct(OutletVisitRepository $outletVisitRepo)
    {
        $this->outletVisitRepository = $outletVisitRepo;
    }

    /**
     * Display a listing of the OutletVisit.
     * GET|HEAD /outletVisits
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $outletVisits = $this->outletVisitRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($outletVisits->toArray(), 'Outlet Visits retrieved successfully');
    }

    /**
     * Store a newly created OutletVisit in storage.
     * POST /outletVisits
     *
     * @param CreateOutletVisitAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateOutletVisitAPIRequest $request)
    {
        $input = $request->all();

        $outletVisit = $this->outletVisitRepository->create($input);

        return $this->sendResponse($outletVisit->toArray(), 'Outlet Visit saved successfully');
    }

    /**
     * Display the specified OutletVisit.
     * GET|HEAD /outletVisits/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var OutletVisit $outletVisit */
        $outletVisit = $this->outletVisitRepository->find($id);

        if (empty($outletVisit)) {
            return $this->sendError('Outlet Visit not found');
        }

        return $this->sendResponse($outletVisit->toArray(), 'Outlet Visit retrieved successfully');
    }

    /**
     * Update the specified OutletVisit in storage.
     * PUT/PATCH /outletVisits/{id}
     *
     * @param int $id
     * @param UpdateOutletVisitAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateOutletVisitAPIRequest $request)
    {
        $input = $request->all();

        /** @var OutletVisit $outletVisit */
        $outletVisit = $this->outletVisitRepository->find($id);

        if (empty($outletVisit)) {
            return $this->sendError('Outlet Visit not found');
        }

        $outletVisit = $this->outletVisitRepository->update($input, $id);

        return $this->sendResponse($outletVisit->toArray(), 'OutletVisit updated successfully');
    }

    /**
     * Remove the specified OutletVisit from storage.
     * DELETE /outletVisits/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var OutletVisit $outletVisit */
        $outletVisit = $this->outletVisitRepository->find($id);

        if (empty($outletVisit)) {
            return $this->sendError('Outlet Visit not found');
        }

        $outletVisit->delete();

        return $this->sendResponse($id, 'Outlet Visit deleted successfully');
    }
}

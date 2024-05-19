<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\API\V1\CreateCurrentStatusesAPIRequest;
use App\Http\Requests\API\V1\UpdateCurrentStatusesAPIRequest;
use App\Models\CurrentStatuses;
use App\Repositories\Backend\CurrentStatusesRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class CurrentStatusesController
 * @package App\Http\Controllers\API\V1
 */

class CurrentStatusesAPIController extends AppBaseController
{
    /** @var  CurrentStatusesRepository */
    private $currentStatusesRepository;

    public function __construct(CurrentStatusesRepository $currentStatusesRepo)
    {
        $this->currentStatusesRepository = $currentStatusesRepo;
    }

    /**
     * Display a listing of the CurrentStatuses.
     * GET|HEAD /currentStatuses
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $currentStatuses = $this->currentStatusesRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($currentStatuses->toArray(), 'Current Statuses retrieved successfully');
    }

    /**
     * Store a newly created CurrentStatuses in storage.
     * POST /currentStatuses
     *
     * @param CreateCurrentStatusesAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateCurrentStatusesAPIRequest $request)
    {
        $input = $request->all();

        $currentStatuses = $this->currentStatusesRepository->create($input);

        return $this->sendResponse($currentStatuses->toArray(), 'Current Statuses saved successfully');
    }

    /**
     * Display the specified CurrentStatuses.
     * GET|HEAD /currentStatuses/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var CurrentStatuses $currentStatuses */
        $currentStatuses = $this->currentStatusesRepository->find($id);

        if (empty($currentStatuses)) {
            return $this->sendError('Current Statuses not found');
        }

        return $this->sendResponse($currentStatuses->toArray(), 'Current Statuses retrieved successfully');
    }

    /**
     * Update the specified CurrentStatuses in storage.
     * PUT/PATCH /currentStatuses/{id}
     *
     * @param int $id
     * @param UpdateCurrentStatusesAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCurrentStatusesAPIRequest $request)
    {
        $input = $request->all();

        /** @var CurrentStatuses $currentStatuses */
        $currentStatuses = $this->currentStatusesRepository->find($id);

        if (empty($currentStatuses)) {
            return $this->sendError('Current Statuses not found');
        }

        $currentStatuses = $this->currentStatusesRepository->update($input, $id);

        return $this->sendResponse($currentStatuses->toArray(), 'CurrentStatuses updated successfully');
    }

    /**
     * Remove the specified CurrentStatuses from storage.
     * DELETE /currentStatuses/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var CurrentStatuses $currentStatuses */
        $currentStatuses = $this->currentStatusesRepository->find($id);

        if (empty($currentStatuses)) {
            return $this->sendError('Current Statuses not found');
        }

        $currentStatuses->delete();

        return $this->sendResponse($id, 'Current Statuses deleted successfully');
    }
}

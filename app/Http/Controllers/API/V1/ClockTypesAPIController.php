<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\API\V1\CreateClockTypesAPIRequest;
use App\Http\Requests\API\V1\UpdateClockTypesAPIRequest;
use App\Models\ClockTypes;
use App\Repositories\Backend\ClockTypesRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class ClockTypesController
 * @package App\Http\Controllers\API\V1
 */

class ClockTypesAPIController extends AppBaseController
{
    /** @var  ClockTypesRepository */
    private $clockTypesRepository;

    public function __construct(ClockTypesRepository $clockTypesRepo)
    {
        $this->clockTypesRepository = $clockTypesRepo;
    }

    /**
     * Display a listing of the ClockTypes.
     * GET|HEAD /clockTypes
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $clockTypes = $this->clockTypesRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($clockTypes->toArray(), 'Clock Types retrieved successfully');
    }

    /**
     * Store a newly created ClockTypes in storage.
     * POST /clockTypes
     *
     * @param CreateClockTypesAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateClockTypesAPIRequest $request)
    {
        $input = $request->all();

        $clockTypes = $this->clockTypesRepository->create($input);

        return $this->sendResponse($clockTypes->toArray(), 'Clock Types saved successfully');
    }

    /**
     * Display the specified ClockTypes.
     * GET|HEAD /clockTypes/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var ClockTypes $clockTypes */
        $clockTypes = $this->clockTypesRepository->find($id);

        if (empty($clockTypes)) {
            return $this->sendError('Clock Types not found');
        }

        return $this->sendResponse($clockTypes->toArray(), 'Clock Types retrieved successfully');
    }

    /**
     * Update the specified ClockTypes in storage.
     * PUT/PATCH /clockTypes/{id}
     *
     * @param int $id
     * @param UpdateClockTypesAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateClockTypesAPIRequest $request)
    {
        $input = $request->all();

        /** @var ClockTypes $clockTypes */
        $clockTypes = $this->clockTypesRepository->find($id);

        if (empty($clockTypes)) {
            return $this->sendError('Clock Types not found');
        }

        $clockTypes = $this->clockTypesRepository->update($input, $id);

        return $this->sendResponse($clockTypes->toArray(), 'ClockTypes updated successfully');
    }

    /**
     * Remove the specified ClockTypes from storage.
     * DELETE /clockTypes/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var ClockTypes $clockTypes */
        $clockTypes = $this->clockTypesRepository->find($id);

        if (empty($clockTypes)) {
            return $this->sendError('Clock Types not found');
        }

        $clockTypes->delete();

        return $this->sendResponse($id, 'Clock Types deleted successfully');
    }
}

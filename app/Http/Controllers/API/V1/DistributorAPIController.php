<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\API\V1\CreateDistributorAPIRequest;
use App\Http\Requests\API\V1\UpdateDistributorAPIRequest;
use App\Models\Distributor;
use App\Repositories\Backend\DistributorRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;
use Illuminate\Support\Facades\Auth;

/**
 * Class DistributorController
 * @package App\Http\Controllers\API\V1
 */

class DistributorAPIController extends AppBaseController
{
    /** @var  DistributorRepository */
    private $distributorRepository;

    public function __construct(DistributorRepository $distributorRepo)
    {
        $this->distributorRepository = $distributorRepo;
    }

    /**
     * Display a listing of the Distributor.
     * GET|HEAD /distributors
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $structures = $request->get('structures');
        $distributors = Distributor::whereIn('structure_id', $structures)->orderByDesc('created_at')->paginate(5);

        return $this->sendResponse($distributors, 'Distributors retrieved successfully');
    }

    /**
     * Store a newly created Distributor in storage.
     * POST /distributors
     *
     * @param CreateDistributorAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateDistributorAPIRequest $request)
    {
        $input = $request->all();

        $distributor = $this->distributorRepository->create($input);

        return $this->sendResponse($distributor->toArray(), 'Distributor saved successfully');
    }

    /**
     * Display the specified Distributor.
     * GET|HEAD /distributors/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Distributor $distributor */
        $distributor = $this->distributorRepository->find($id);

        if (empty($distributor)) {
            return $this->sendError('Distributor not found');
        }

        return $this->sendResponse($distributor->toArray(), 'Distributor retrieved successfully');
    }

    /**
     * Update the specified Distributor in storage.
     * PUT/PATCH /distributors/{id}
     *
     * @param int $id
     * @param UpdateDistributorAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDistributorAPIRequest $request)
    {
        $input = $request->all();

        /** @var Distributor $distributor */
        $distributor = $this->distributorRepository->find($id);

        if (empty($distributor)) {
            return $this->sendError('Distributor not found');
        }

        $distributor = $this->distributorRepository->update($input, $id);

        return $this->sendResponse($distributor->toArray(), 'Distributor updated successfully');
    }

    /**
     * Remove the specified Distributor from storage.
     * DELETE /distributors/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Distributor $distributor */
        $distributor = $this->distributorRepository->find($id);

        if (empty($distributor)) {
            return $this->sendError('Distributor not found');
        }

        $distributor->delete();

        return $this->sendResponse($id, 'Distributor deleted successfully');
    }
}

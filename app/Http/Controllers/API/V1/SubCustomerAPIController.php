<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\API\V1\CreateSubCustomerAPIRequest;
use App\Http\Requests\API\V1\UpdateSubCustomerAPIRequest;
use App\Models\SubCustomer;
use App\Repositories\Backend\SubCustomerRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class SubCustomerController
 * @package App\Http\Controllers\API\V1
 */

class SubCustomerAPIController extends AppBaseController
{
    /** @var  SubCustomerRepository */
    private $subCustomerRepository;

    public function __construct(SubCustomerRepository $subCustomerRepo)
    {
        $this->subCustomerRepository = $subCustomerRepo;
    }

    /**
     * Display a listing of the SubCustomer.
     * GET|HEAD /subCustomers
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $subCustomers = $this->subCustomerRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($subCustomers->toArray(), 'Sub Customers retrieved successfully');
    }

    /**
     * Store a newly created SubCustomer in storage.
     * POST /subCustomers
     *
     * @param CreateSubCustomerAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateSubCustomerAPIRequest $request)
    {
        $input = $request->all();

        $subCustomer = $this->subCustomerRepository->create($input);

        return $this->sendResponse($subCustomer->toArray(), 'Sub Customer saved successfully');
    }
    public function storeApi(Request $request)
    {
        $input = $request->all();
        \Log::debug($input);
        $subCustomer = $this->subCustomerRepository->createApi($input);

        return $this->sendResponse($subCustomer->toArray(), 'Sub Customer saved successfully');
    }

    /**
     * Display the specified SubCustomer.
     * GET|HEAD /subCustomers/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var SubCustomer $subCustomer */
        $subCustomer = $this->subCustomerRepository->find($id);

        if (empty($subCustomer)) {
            return $this->sendError('Sub Customer not found');
        }

        return $this->sendResponse($subCustomer->toArray(), 'Sub Customer retrieved successfully');
    }

    /**
     * Update the specified SubCustomer in storage.
     * PUT/PATCH /subCustomers/{id}
     *
     * @param int $id
     * @param UpdateSubCustomerAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSubCustomerAPIRequest $request)
    {
        $input = $request->all();

        /** @var SubCustomer $subCustomer */
        $subCustomer = $this->subCustomerRepository->find($id);

        if (empty($subCustomer)) {
            return $this->sendError('Sub Customer not found');
        }

        $subCustomer = $this->subCustomerRepository->update($input, $id);

        return $this->sendResponse($subCustomer->toArray(), 'SubCustomer updated successfully');
    }

    /**
     * Remove the specified SubCustomer from storage.
     * DELETE /subCustomers/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var SubCustomer $subCustomer */
        $subCustomer = $this->subCustomerRepository->find($id);

        if (empty($subCustomer)) {
            return $this->sendError('Sub Customer not found');
        }

        $subCustomer->delete();

        return $this->sendSuccess('Sub Customer deleted successfully');
    }
}

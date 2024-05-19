<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\API\V1\CreateCustomerDetailAPIRequest;
use App\Http\Requests\API\V1\UpdateCustomerDetailAPIRequest;
use App\Models\CustomerDetail;
use App\Repositories\Backend\CustomerDetailRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\CustomerDetailResource;
use Response;

/**
 * Class CustomerDetailController
 * @package App\Http\Controllers\API\V1
 */

class CustomerDetailAPIController extends AppBaseController
{
    /** @var  CustomerDetailRepository */
    private $customerDetailRepository;

    public function __construct(CustomerDetailRepository $customerDetailRepo)
    {
        $this->customerDetailRepository = $customerDetailRepo;
    }

    /**
     * Display a listing of the CustomerDetail.
     * GET|HEAD /customerDetails
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $customerDetails = $this->customerDetailRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(CustomerDetailResource::collection($customerDetails), 'Customer Details retrieved successfully');
    }

    /**
     * Store a newly created CustomerDetail in storage.
     * POST /customerDetails
     *
     * @param CreateCustomerDetailAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateCustomerDetailAPIRequest $request)
    {
        $input = $request->all();

        $customerDetail = $this->customerDetailRepository->create($input);

        return $this->sendResponse(new CustomerDetailResource($customerDetail), 'Customer Detail saved successfully');
    }

    /**
     * Display the specified CustomerDetail.
     * GET|HEAD /customerDetails/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var CustomerDetail $customerDetail */
        $customerDetail = $this->customerDetailRepository->find($id);

        if (empty($customerDetail)) {
            return $this->sendError('Customer Detail not found');
        }

        return $this->sendResponse(new CustomerDetailResource($customerDetail), 'Customer Detail retrieved successfully');
    }

    /**
     * Update the specified CustomerDetail in storage.
     * PUT/PATCH /customerDetails/{id}
     *
     * @param int $id
     * @param UpdateCustomerDetailAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCustomerDetailAPIRequest $request)
    {
        $input = $request->all();

        /** @var CustomerDetail $customerDetail */
        $customerDetail = $this->customerDetailRepository->find($id);

        if (empty($customerDetail)) {
            return $this->sendError('Customer Detail not found');
        }

        $customerDetail = $this->customerDetailRepository->update($input, $id);

        return $this->sendResponse(new CustomerDetailResource($customerDetail), 'CustomerDetail updated successfully');
    }

    /**
     * Remove the specified CustomerDetail from storage.
     * DELETE /customerDetails/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var CustomerDetail $customerDetail */
        $customerDetail = $this->customerDetailRepository->find($id);

        if (empty($customerDetail)) {
            return $this->sendError('Customer Detail not found');
        }

        $customerDetail->delete();

        return $this->sendSuccess('Customer Detail deleted successfully');
    }
}

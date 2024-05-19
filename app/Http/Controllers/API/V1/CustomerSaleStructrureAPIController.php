<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\API\V1\CreateCustomerSaleStructrureAPIRequest;
use App\Http\Requests\API\V1\UpdateCustomerSaleStructrureAPIRequest;
use App\Models\CustomerSaleStructrure;
use App\Repositories\Backend\CustomerSaleStructrureRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class CustomerSaleStructrureController
 * @package App\Http\Controllers\API\V1
 */

class CustomerSaleStructrureAPIController extends AppBaseController
{
    /** @var  CustomerSaleStructrureRepository */
    private $customerSaleStructrureRepository;

    public function __construct(CustomerSaleStructrureRepository $customerSaleStructrureRepo)
    {
        $this->customerSaleStructrureRepository = $customerSaleStructrureRepo;
    }

    /**
     * Display a listing of the CustomerSaleStructrure.
     * GET|HEAD /customerSaleStructrures
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $customerSaleStructrures = $this->customerSaleStructrureRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($customerSaleStructrures->toArray(), 'Customer Sale Structrures retrieved successfully');
    }

    /**
     * Store a newly created CustomerSaleStructrure in storage.
     * POST /customerSaleStructrures
     *
     * @param CreateCustomerSaleStructrureAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateCustomerSaleStructrureAPIRequest $request)
    {
        $input = $request->all();

        $customerSaleStructrure = $this->customerSaleStructrureRepository->create($input);

        return $this->sendResponse($customerSaleStructrure->toArray(), 'Customer Sale Structrure saved successfully');
    }

    /**
     * Display the specified CustomerSaleStructrure.
     * GET|HEAD /customerSaleStructrures/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var CustomerSaleStructrure $customerSaleStructrure */
        $customerSaleStructrure = $this->customerSaleStructrureRepository->find($id);

        if (empty($customerSaleStructrure)) {
            return $this->sendError('Customer Sale Structrure not found');
        }

        return $this->sendResponse($customerSaleStructrure->toArray(), 'Customer Sale Structrure retrieved successfully');
    }

    /**
     * Update the specified CustomerSaleStructrure in storage.
     * PUT/PATCH /customerSaleStructrures/{id}
     *
     * @param int $id
     * @param UpdateCustomerSaleStructrureAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCustomerSaleStructrureAPIRequest $request)
    {
        $input = $request->all();

        /** @var CustomerSaleStructrure $customerSaleStructrure */
        $customerSaleStructrure = $this->customerSaleStructrureRepository->find($id);

        if (empty($customerSaleStructrure)) {
            return $this->sendError('Customer Sale Structrure not found');
        }

        $customerSaleStructrure = $this->customerSaleStructrureRepository->update($input, $id);

        return $this->sendResponse($customerSaleStructrure->toArray(), 'CustomerSaleStructrure updated successfully');
    }

    /**
     * Remove the specified CustomerSaleStructrure from storage.
     * DELETE /customerSaleStructrures/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var CustomerSaleStructrure $customerSaleStructrure */
        $customerSaleStructrure = $this->customerSaleStructrureRepository->find($id);

        if (empty($customerSaleStructrure)) {
            return $this->sendError('Customer Sale Structrure not found');
        }

        $customerSaleStructrure->delete();

        return $this->sendResponse($id, 'Customer Sale Structrure deleted successfully');
    }
}

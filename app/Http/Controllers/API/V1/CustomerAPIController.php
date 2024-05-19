<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\API\V1\CreateCustomerAPIRequest;
use App\Http\Requests\API\V1\UpdateCustomerAPIRequest;
use App\Models\Customer;
use App\Repositories\Backend\CustomerRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\CustomerResource;
use App\Models\Route;
use Carbon\Carbon;
use Response;
use Illuminate\Support\Facades\Auth;

/**
 * Class CustomerController
 * @package App\Http\Controllers\API\V1
 */

class CustomerAPIController extends AppBaseController
{
    /** @var  CustomerRepository */
    private $customerRepository;

    public function __construct(CustomerRepository $customerRepo)
    {
        $this->customerRepository = $customerRepo;
    }

    /**
     * Display a listing of the Customer.
     * GET|HEAD /customers
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $structures = $request->get('structures');
        $customers = Customer::orderByDesc('created_at')->with('channel')->paginate(5);

        return $this->sendResponse($customers, 'Customers retrieved successfully');
    }

    public function listByRoute($route_id)
    {
        $customers = $this->customerRepository->getbyRouteId($route_id);

        return $this->sendResponse(CustomerResource::collection($customers), 'Customers retrieved successfully');
    }

    public function indexapp(Request $request)
    {
        $user_id = Auth::guard('api')->user()->id;
        $rep_id = Auth::guard('api')->user()->rep_id;
        // $date = Carbon::now()->toArray();
        // $day_of_week = $date['dayOfWeek'];
        // $routes = Route::where('user_id' ,$user_id)->where("route_pjp", $day_of_week)->pluck('id')->toArray();
        $structures = $request->get('structures');
        $customers = Customer::whereIn('structure_id', $structures)->with('channel', 'route', 'town')->where('user_id', $user_id)->orderByDesc('created_at')->get();

        return $this->sendResponse($customers->toArray(), 'Customers retrieved successfully');
    }

    /**
     * Store a newly created Customer in storage.
     * POST /customers
     *
     * @param CreateCustomerAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateCustomerAPIRequest $request)
    {
        $input = $request->all();

        $customer = $this->customerRepository->create($input);

        return $this->sendResponse($customer->toArray(), 'Customer saved successfully');
    }

    public function storeApi(Request $request)
    {
        $input = $request->all();
        \Log::debug($input);
        $customer = $this->customerRepository->createApi($input);

        return $this->sendResponse($customer->toArray(), 'Customer saved successfully');
    }

    /**
     * Display the specified Customer.
     * GET|HEAD /customers/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Customer $customer */
        $customer = $this->customerRepository->find($id);

        if (empty($customer)) {
            return $this->sendError('Customer not found');
        }

        return $this->sendResponse($customer->toArray(), 'Customer retrieved successfully');
    }

    /**
     * Update the specified Customer in storage.
     * PUT/PATCH /customers/{id}
     *
     * @param int $id
     * @param UpdateCustomerAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCustomerAPIRequest $request)
    {
        $input = $request->all();

        /** @var Customer $customer */
        $customer = $this->customerRepository->find($id);

        if (empty($customer)) {
            return $this->sendError('Customer not found');
        }

        $customer = $this->customerRepository->update($input, $id);

        return $this->sendResponse($customer->toArray(), 'Customer updated successfully');
    }
    public function updateApi($id, UpdateCustomerAPIRequest $request)
    {
        $input = $request->all();

        /** @var Customer $customer */
        $customer = $this->customerRepository->find($id);

        if (empty($customer)) {
            return $this->sendError('Customer not found');
        }

        $customer = $this->customerRepository->updateApi($input, $id);

        return $this->sendResponse($customer->toArray(), 'Customer updated successfully');
    }

    /**
     * Remove the specified Customer from storage.
     * DELETE /customers/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Customer $customer */
        $customer = $this->customerRepository->find($id);

        if (empty($customer)) {
            return $this->sendError('Customer not found');
        }

        $customer->delete();

        return $this->sendResponse($id, 'Customer deleted successfully');
    }
}

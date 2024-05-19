<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\CustomerSaleStructrureDataTable;
use App\Http\Requests\Backend;
use App\Http\Requests\Backend\CreateCustomerSaleStructrureRequest;
use App\Http\Requests\Backend\UpdateCustomerSaleStructrureRequest;
use App\Repositories\Backend\CustomerSaleStructrureRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class CustomerSaleStructrureController extends AppBaseController
{
    /** @var  CustomerSaleStructrureRepository */
    private $customerSaleStructrureRepository;

    public function __construct(CustomerSaleStructrureRepository $customerSaleStructrureRepo)
    {
        $this->customerSaleStructrureRepository = $customerSaleStructrureRepo;
    }

    /**
     * Display a listing of the CustomerSaleStructrure.
     *
     * @param CustomerSaleStructrureDataTable $customerSaleStructrureDataTable
     * @return Response
     */
    public function index(CustomerSaleStructrureDataTable $customerSaleStructrureDataTable)
    {
        return $customerSaleStructrureDataTable->render('customer_sale_structrures.index');
    }

    /**
     * Show the form for creating a new CustomerSaleStructrure.
     *
     * @return Response
     */
    public function create()
    {
        return view('customer_sale_structrures.create');
    }

    /**
     * Store a newly created CustomerSaleStructrure in storage.
     *
     * @param CreateCustomerSaleStructrureRequest $request
     *
     * @return Response
     */
    public function store(CreateCustomerSaleStructrureRequest $request)
    {
        $input = $request->all();

        $customerSaleStructrure = $this->customerSaleStructrureRepository->create($input);

        Flash::success('Customer Sale Structrure saved successfully.');

        return redirect(route('customerSaleStructrures.index'));
    }

    /**
     * Display the specified CustomerSaleStructrure.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $customerSaleStructrure = $this->customerSaleStructrureRepository->find($id);

        if (empty($customerSaleStructrure)) {
            Flash::error('Customer Sale Structrure not found');

            return redirect(route('customerSaleStructrures.index'));
        }

        return view('customer_sale_structrures.show')->with('customerSaleStructrure', $customerSaleStructrure);
    }

    /**
     * Show the form for editing the specified CustomerSaleStructrure.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $customerSaleStructrure = $this->customerSaleStructrureRepository->find($id);

        if (empty($customerSaleStructrure)) {
            Flash::error('Customer Sale Structrure not found');

            return redirect(route('customerSaleStructrures.index'));
        }

        return view('customer_sale_structrures.edit')->with('customerSaleStructrure', $customerSaleStructrure);
    }

    /**
     * Update the specified CustomerSaleStructrure in storage.
     *
     * @param  int              $id
     * @param UpdateCustomerSaleStructrureRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCustomerSaleStructrureRequest $request)
    {
        $customerSaleStructrure = $this->customerSaleStructrureRepository->find($id);

        if (empty($customerSaleStructrure)) {
            Flash::error('Customer Sale Structrure not found');

            return redirect(route('customerSaleStructrures.index'));
        }

        $customerSaleStructrure = $this->customerSaleStructrureRepository->update($request->all(), $id);

        Flash::success('Customer Sale Structrure updated successfully.');

        return redirect(route('customerSaleStructrures.index'));
    }

    /**
     * Remove the specified CustomerSaleStructrure from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $customerSaleStructrure = $this->customerSaleStructrureRepository->find($id);

        if (empty($customerSaleStructrure)) {
            Flash::error('Customer Sale Structrure not found');

            return redirect(route('customerSaleStructrures.index'));
        }

        $this->customerSaleStructrureRepository->delete($id);

        Flash::success('Customer Sale Structrure deleted successfully.');

        return redirect(route('customerSaleStructrures.index'));
    }
}

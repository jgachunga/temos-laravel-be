<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\PaymentMethodsDataTable;
use App\Http\Requests\Backend;
use App\Http\Requests\Backend\CreatePaymentMethodsRequest;
use App\Http\Requests\Backend\UpdatePaymentMethodsRequest;
use App\Repositories\Backend\PaymentMethodsRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class PaymentMethodsController extends AppBaseController
{
    /** @var  PaymentMethodsRepository */
    private $paymentMethodsRepository;

    public function __construct(PaymentMethodsRepository $paymentMethodsRepo)
    {
        $this->paymentMethodsRepository = $paymentMethodsRepo;
    }

    /**
     * Display a listing of the PaymentMethods.
     *
     * @param PaymentMethodsDataTable $paymentMethodsDataTable
     * @return Response
     */
    public function index(PaymentMethodsDataTable $paymentMethodsDataTable)
    {
        return $paymentMethodsDataTable->render('payment_methods.index');
    }

    /**
     * Show the form for creating a new PaymentMethods.
     *
     * @return Response
     */
    public function create()
    {
        return view('payment_methods.create');
    }

    /**
     * Store a newly created PaymentMethods in storage.
     *
     * @param CreatePaymentMethodsRequest $request
     *
     * @return Response
     */
    public function store(CreatePaymentMethodsRequest $request)
    {
        $input = $request->all();

        $paymentMethods = $this->paymentMethodsRepository->create($input);

        Flash::success('Payment Methods saved successfully.');

        return redirect(route('paymentMethods.index'));
    }

    /**
     * Display the specified PaymentMethods.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $paymentMethods = $this->paymentMethodsRepository->find($id);

        if (empty($paymentMethods)) {
            Flash::error('Payment Methods not found');

            return redirect(route('paymentMethods.index'));
        }

        return view('payment_methods.show')->with('paymentMethods', $paymentMethods);
    }

    /**
     * Show the form for editing the specified PaymentMethods.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $paymentMethods = $this->paymentMethodsRepository->find($id);

        if (empty($paymentMethods)) {
            Flash::error('Payment Methods not found');

            return redirect(route('paymentMethods.index'));
        }

        return view('payment_methods.edit')->with('paymentMethods', $paymentMethods);
    }

    /**
     * Update the specified PaymentMethods in storage.
     *
     * @param  int              $id
     * @param UpdatePaymentMethodsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePaymentMethodsRequest $request)
    {
        $paymentMethods = $this->paymentMethodsRepository->find($id);

        if (empty($paymentMethods)) {
            Flash::error('Payment Methods not found');

            return redirect(route('paymentMethods.index'));
        }

        $paymentMethods = $this->paymentMethodsRepository->update($request->all(), $id);

        Flash::success('Payment Methods updated successfully.');

        return redirect(route('paymentMethods.index'));
    }

    /**
     * Remove the specified PaymentMethods from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $paymentMethods = $this->paymentMethodsRepository->find($id);

        if (empty($paymentMethods)) {
            Flash::error('Payment Methods not found');

            return redirect(route('paymentMethods.index'));
        }

        $this->paymentMethodsRepository->delete($id);

        Flash::success('Payment Methods deleted successfully.');

        return redirect(route('paymentMethods.index'));
    }
}

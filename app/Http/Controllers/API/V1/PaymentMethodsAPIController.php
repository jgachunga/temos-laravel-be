<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\API\V1\CreatePaymentMethodsAPIRequest;
use App\Http\Requests\API\V1\UpdatePaymentMethodsAPIRequest;
use App\Models\PaymentMethods;
use App\Repositories\Backend\PaymentMethodsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class PaymentMethodsController
 * @package App\Http\Controllers\API\V1
 */

class PaymentMethodsAPIController extends AppBaseController
{
    /** @var  PaymentMethodsRepository */
    private $paymentMethodsRepository;

    public function __construct(PaymentMethodsRepository $paymentMethodsRepo)
    {
        $this->paymentMethodsRepository = $paymentMethodsRepo;
    }

    /**
     * Display a listing of the PaymentMethods.
     * GET|HEAD /paymentMethods
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $paymentMethods = $this->paymentMethodsRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($paymentMethods->toArray(), 'Payment Methods retrieved successfully');
    }

    /**
     * Store a newly created PaymentMethods in storage.
     * POST /paymentMethods
     *
     * @param CreatePaymentMethodsAPIRequest $request
     *
     * @return Response
     */
    public function store(CreatePaymentMethodsAPIRequest $request)
    {
        $input = $request->all();

        $paymentMethods = $this->paymentMethodsRepository->create($input);

        return $this->sendResponse($paymentMethods->toArray(), 'Payment Methods saved successfully');
    }

    /**
     * Display the specified PaymentMethods.
     * GET|HEAD /paymentMethods/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var PaymentMethods $paymentMethods */
        $paymentMethods = $this->paymentMethodsRepository->find($id);

        if (empty($paymentMethods)) {
            return $this->sendError('Payment Methods not found');
        }

        return $this->sendResponse($paymentMethods->toArray(), 'Payment Methods retrieved successfully');
    }

    /**
     * Update the specified PaymentMethods in storage.
     * PUT/PATCH /paymentMethods/{id}
     *
     * @param int $id
     * @param UpdatePaymentMethodsAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePaymentMethodsAPIRequest $request)
    {
        $input = $request->all();

        /** @var PaymentMethods $paymentMethods */
        $paymentMethods = $this->paymentMethodsRepository->find($id);

        if (empty($paymentMethods)) {
            return $this->sendError('Payment Methods not found');
        }

        $paymentMethods = $this->paymentMethodsRepository->update($input, $id);

        return $this->sendResponse($paymentMethods->toArray(), 'PaymentMethods updated successfully');
    }

    /**
     * Remove the specified PaymentMethods from storage.
     * DELETE /paymentMethods/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var PaymentMethods $paymentMethods */
        $paymentMethods = $this->paymentMethodsRepository->find($id);

        if (empty($paymentMethods)) {
            return $this->sendError('Payment Methods not found');
        }

        $paymentMethods->delete();

        return $this->sendResponse($id, 'Payment Methods deleted successfully');
    }
}

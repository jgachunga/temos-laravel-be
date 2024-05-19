<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\API\V1\CreateInvoiceDetailAPIRequest;
use App\Http\Requests\API\V1\UpdateInvoiceDetailAPIRequest;
use App\Models\InvoiceDetail;
use App\Repositories\Backend\InvoiceDetailRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class InvoiceDetailController
 * @package App\Http\Controllers\API\V1
 */

class InvoiceDetailAPIController extends AppBaseController
{
    /** @var  InvoiceDetailRepository */
    private $invoiceDetailRepository;

    public function __construct(InvoiceDetailRepository $invoiceDetailRepo)
    {
        $this->invoiceDetailRepository = $invoiceDetailRepo;
    }

    /**
     * Display a listing of the InvoiceDetail.
     * GET|HEAD /invoiceDetails
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $invoiceDetails = $this->invoiceDetailRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($invoiceDetails->toArray(), 'Invoice Details retrieved successfully');
    }

    /**
     * Store a newly created InvoiceDetail in storage.
     * POST /invoiceDetails
     *
     * @param CreateInvoiceDetailAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateInvoiceDetailAPIRequest $request)
    {
        $input = $request->all();

        $invoiceDetail = $this->invoiceDetailRepository->create($input);

        return $this->sendResponse($invoiceDetail->toArray(), 'Invoice Detail saved successfully');
    }

    /**
     * Display the specified InvoiceDetail.
     * GET|HEAD /invoiceDetails/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var InvoiceDetail $invoiceDetail */
        $invoiceDetail = $this->invoiceDetailRepository->find($id);

        if (empty($invoiceDetail)) {
            return $this->sendError('Invoice Detail not found');
        }

        return $this->sendResponse($invoiceDetail->toArray(), 'Invoice Detail retrieved successfully');
    }

    /**
     * Update the specified InvoiceDetail in storage.
     * PUT/PATCH /invoiceDetails/{id}
     *
     * @param int $id
     * @param UpdateInvoiceDetailAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateInvoiceDetailAPIRequest $request)
    {
        $input = $request->all();

        /** @var InvoiceDetail $invoiceDetail */
        $invoiceDetail = $this->invoiceDetailRepository->find($id);

        if (empty($invoiceDetail)) {
            return $this->sendError('Invoice Detail not found');
        }

        $invoiceDetail = $this->invoiceDetailRepository->update($input, $id);

        return $this->sendResponse($invoiceDetail->toArray(), 'InvoiceDetail updated successfully');
    }

    /**
     * Remove the specified InvoiceDetail from storage.
     * DELETE /invoiceDetails/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var InvoiceDetail $invoiceDetail */
        $invoiceDetail = $this->invoiceDetailRepository->find($id);

        if (empty($invoiceDetail)) {
            return $this->sendError('Invoice Detail not found');
        }

        $invoiceDetail->delete();

        return $this->sendResponse($id, 'Invoice Detail deleted successfully');
    }
}

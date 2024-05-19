<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\API\V1\CreateInvoiceAPIRequest;
use App\Http\Requests\API\V1\UpdateInvoiceAPIRequest;
use App\Models\Invoice;
use App\Repositories\Backend\InvoiceRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Auth;
use Log;
use Response;

/**
 * Class InvoiceController
 * @package App\Http\Controllers\API\V1
 */

class InvoiceAPIController extends AppBaseController
{
    /** @var  InvoiceRepository */
    private $invoiceRepository;

    public function __construct(InvoiceRepository $invoiceRepo)
    {
        $this->invoiceRepository = $invoiceRepo;
    }

    /**
     * Display a listing of the Invoice.
     * GET|HEAD /invoices
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $invoices = $this->invoiceRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($invoices->toArray(), 'Invoices retrieved successfully');
    }
    public function list(Request $request)
    {
        $structures = $request->get('structures');
        $invoices = Invoice::with('customer', 'items.product', 'structure', 'user', 'payment_method')->whereIn('structure_id', $structures)->where('raise_order', '!=', 1)->orderByDesc('created_at')->paginate(10);

        return $this->sendResponse($invoices->toArray(), 'Invoices retrieved successfully');
    }
    public function listInvoices(Request $request)
    {
        $user = Auth::guard('api')->user();
        $invoices = Invoice::with('customer.route', 'items.product', 'stockist')->where('user_id', $user->id)
        ->orderByDesc('created_at')->limit(15)->get();

        return $this->sendResponse($invoices->toArray(), 'Invoices retrieved successfully');
    }
    /**
     * Store a newly created Invoice in storage.
     * POST /invoices
     *
     * @param CreateInvoiceAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateInvoiceAPIRequest $request)
    {
        $input = $request->all();
        Log::debug($input);
        $invoice = $this->invoiceRepository->create($input);

        return $this->sendResponse($invoice->toArray(), 'Invoice saved successfully');
    }
    public function sync(Request $request)
    {
        $input = $request->all();
        // Log::debug($input);
        $invoice = $this->invoiceRepository->create($input);
        $success_obj=array('Code' => 201,'Status'=>'Success','Message'=> 'Invoices sent successfully' );
        return $success_obj;
        return $this->sendResponse($success_obj, 'Invoice saved successfully');
    }
    public function confirmOrder(Request $request)
    {
        $input = $request->all();
        // Log::debug($input);
        $invoice = $this->invoiceRepository->updateOrder($input);
        $success_obj=array('Code' => 201,'status'=>'Success','Message'=> 'Order updated successfully' );
        return $success_obj;
        return $this->sendResponse($success_obj, 'Order saved successfully');
    }

    public function confirmOrderNew($id)
    {
        $invoice = $this->invoiceRepository->confirmInvoiceOrder($id);
        $success_obj=array('Code' => 201,'status'=>'Success','Message'=> 'Order updated successfully' );
        return $success_obj;
        return $this->sendResponse($success_obj, 'Order saved successfully');
    }

    /**
     * Display the specified Invoice.
     * GET|HEAD /invoices/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Invoice $invoice */
        $invoice = $this->invoiceRepository->find($id);

        if (empty($invoice)) {
            return $this->sendError('Invoice not found');
        }

        return $this->sendResponse($invoice->toArray(), 'Invoice retrieved successfully');
    }

    /**
     * Update the specified Invoice in storage.
     * PUT/PATCH /invoices/{id}
     *
     * @param int $id
     * @param UpdateInvoiceAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateInvoiceAPIRequest $request)
    {
        $input = $request->all();

        /** @var Invoice $invoice */
        $invoice = $this->invoiceRepository->find($id);

        if (empty($invoice)) {
            return $this->sendError('Invoice not found');
        }

        $invoice = $this->invoiceRepository->update($input, $id);

        return $this->sendResponse($invoice->toArray(), 'Invoice updated successfully');
    }

    /**
     * Remove the specified Invoice from storage.
     * DELETE /invoices/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Invoice $invoice */
        $invoice = $this->invoiceRepository->find($id);

        if (empty($invoice)) {
            return $this->sendError('Invoice not found');
        }

        $invoice->delete();

        return $this->sendResponse($id, 'Invoice deleted successfully');
    }
}

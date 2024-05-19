<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\API\V1\CreateSyncAPIRequest;
use App\Http\Requests\API\V1\UpdateSyncAPIRequest;
use App\Models\Sync;
use App\Repositories\Backend\SyncRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\CustomerResource;
use App\Http\Resources\SyncResource;
use App\Models\Customer;
use App\Repositories\Backend\ClockInRepository;
use App\Repositories\Backend\CustomerDetailRepository;
use App\Repositories\Backend\CustomerRepository;
use App\Repositories\Backend\FormPhotoRepository;
use App\Repositories\Backend\FormsAnsweredRepository;
use App\Repositories\Backend\FormsAnswersRepository;
use App\Repositories\Backend\InvoiceRepository;
use Response;

/**
 * Class SyncController
 * @package App\Http\Controllers\API\V1
 */

class SyncAPIController extends AppBaseController
{
    /** @var  SyncRepository */
    private $syncRepository;

    public function __construct(
        SyncRepository $syncRepo,
        CustomerRepository $customerRepository,
        InvoiceRepository $invoiceRepository,
        ClockInRepository $clockInRepository,
        CustomerDetailRepository $customerDetailRepo,
        FormsAnsweredRepository $formsAnsweredRepository,
        FormsAnswersRepository $formsAnswersRepository,
        FormPhotoRepository $formPhotoRepository
    )
    {
        $this->syncRepository = $syncRepo;
        $this->customerRepository = $customerRepository;
        $this->invoiceRepository = $invoiceRepository;
        $this->clockInRepository = $clockInRepository;
        $this->customerDetailRepo = $customerDetailRepo;
        $this->formsAnsweredRepository = $formsAnsweredRepository;
        $this->formsAnswersRepository = $formsAnswersRepository;
        $this->formPhotoRepository = $formPhotoRepository;
    }

    /**
     * Display a listing of the Sync.
     * GET|HEAD /syncs
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $syncs = $this->syncRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(SyncResource::collection($syncs), 'Syncs retrieved successfully');
    }

    public function customerSync(Request $request){
        $inputCustomers = $request->except(['structure_id', 'structures']);
        $customers = [];

        foreach($inputCustomers as $inputCustomer){
            if($inputCustomer['customer_id']  == null){

                $customer = $this->customerRepository->createApi($inputCustomer);
                $cust = Customer::where('id', $customer->id)
                ->with('channel', 'route', 'sub_customers')
                ->orderByDesc('created_at')
                ->first();

                $customers[] = $cust;
            }else{
                $visitedAt = null;
                if(isset($data['visited_at']) && $data['visited_at']!='null'){
                    $visitedAt = \Carbon\Carbon::createFromFormat('D M d Y H:i:s e+',$data['visited_at'])->toDateTimeString();
                }
                $input_array= [
                    "visited_at" => $visitedAt
                ];
                $Customer = Customer::find($inputCustomer['customer_id']);
                $Customer = tap($Customer)->update($input_array);
                $cust = Customer::where('id', $Customer->id)
                ->with('channel', 'route', 'sub_customers')
                ->orderByDesc('created_at')
                ->first();

                $customers[] = $cust;
            }
        }
        return $this->sendResponse(CustomerResource::collection($customers), 'Syncs customers successfully');
    }

    public function invoiceSync(Request $request){
        $inputInvoices = $request->except(['structure_id', 'structures']);
        $invoices = [];

        foreach($inputInvoices as $inputInvoice){

            $invoice = $this->invoiceRepository->create($inputInvoice);
            $invoices[] = $invoice->invoice_uuid;

        }
        return $this->sendResponse($invoices, 'Syncs invoices successfully');
    }

    public function clockInSync(Request $request){
        $inputClockIn = $request->except(['structure_id', 'structures']);
        $clockIn = $this->clockInRepository->create($inputClockIn);

        return $this->sendResponse($clockIn, 'Syncs clockiN successfully');
    }

    public function surveySync(Request $request){
        $inputSurvey = $request->except(['structure_id', 'structures']);

        $customer_details = $inputSurvey['customer_details'];
        $customer_forms = $inputSurvey['customer_forms'];
        $answers = $inputSurvey['answersArr'];
        $photosToupdate = $inputSurvey['photosToupdate'];

        $customer_details_saved = $this->customerDetailRepo->create($customer_details);
        $formsAnswered = $this->formsAnsweredRepository->create($customer_forms);
        $form_answers = $this->formsAnswersRepository->create($answers);
        $photos = $this->formPhotoRepository->create($photosToupdate);

        return $this->sendResponse([], 'Syncs survey successfully');
    }


    /**
     * Store a newly created Sync in storage.
     * POST /syncs
     *
     * @param CreateSyncAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateSyncAPIRequest $request)
    {
        $input = $request->all();

        $sync = $this->syncRepository->create($input);

        return $this->sendResponse(new SyncResource($sync), 'Sync saved successfully');
    }

    /**
     * Display the specified Sync.
     * GET|HEAD /syncs/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Sync $sync */
        $sync = $this->syncRepository->find($id);

        if (empty($sync)) {
            return $this->sendError('Sync not found');
        }

        return $this->sendResponse(new SyncResource($sync), 'Sync retrieved successfully');
    }

    /**
     * Update the specified Sync in storage.
     * PUT/PATCH /syncs/{id}
     *
     * @param int $id
     * @param UpdateSyncAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSyncAPIRequest $request)
    {
        $input = $request->all();

        /** @var Sync $sync */
        $sync = $this->syncRepository->find($id);

        if (empty($sync)) {
            return $this->sendError('Sync not found');
        }

        $sync = $this->syncRepository->update($input, $id);

        return $this->sendResponse(new SyncResource($sync), 'Sync updated successfully');
    }

    /**
     * Remove the specified Sync from storage.
     * DELETE /syncs/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Sync $sync */
        $sync = $this->syncRepository->find($id);

        if (empty($sync)) {
            return $this->sendError('Sync not found');
        }

        $sync->delete();

        return $this->sendSuccess('Sync deleted successfully');
    }
}

<?php

namespace App\Repositories\Backend;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\OutletVisit;
use App\Models\SubCustomer;
use App\Models\UserLocationHistory;
use App\Models\UserStatus;
use App\Repositories\BaseRepository;
use Auth;
use DB;
use Exception;
use Log;

/**
 * Class InvoiceRepository
 * @package App\Repositories\Backend
 * @version March 6, 2020, 10:32 am EAT
*/

class InvoiceRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'ref',
        'business_code',
        'sub_total',
        'discount',
        'total_tax',
        'grand_total',
        'date_due',
        'is_approved',
        'created_by',
        'customer_id',
        'approved_by',
        'updated_by',
        'payment_details',
        'terms',
        'footer',
        'structure_id'
    ];

    public function __construct(Invoice $model)
    {
        $this->model = $model;
    }
    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function create(array $data) : Invoice
    {
        $structure_id = Auth::guard('api')->user()->logged_structure_id;
        if($structure_id==null){
            $structure_id = Auth::guard('api')->user()->structure_id;
        }
        $user_id = Auth::guard('api')->user()->id;
        $invoice = $data;
        $invoice_uuid = isset($invoice['uuid']) ? $invoice['uuid'] : '';
        $c_detail_uuid = isset($invoice['c_detail_uuid']) ? $invoice['c_detail_uuid'] : '';
        $InvoiceModel = Invoice::where('invoice_uuid', $invoice_uuid);
        $invoice_uuid_count = Invoice::where('invoice_uuid', $invoice_uuid)->count();
        \Log::debug($invoice_uuid_count);
        if($invoice_uuid_count==0){
            try{
                $data = [];
                $data = (array)json_decode($invoice['invoice_data']);
                $invoice_date = \Carbon\Carbon::createFromFormat('D M d Y H:i:s e+',$data['timestamp'])->toDateTimeString();
                $data['structure_id'] = $structure_id;

                // dd($data['raise_order']);
                $location = json_decode($data['location']);
                $geo_timestamp = \Carbon\Carbon::createFromTimestamp($location->timestamp/1000)->toDateTimeString();
                $customer_id = null;
                if($data['customer_id'] == null){
                    $customerRecord = Customer::where('uuid', $data['customer_uuid'])->first();
                    if(isset($customerRecord->id)){
                        $customer_id = $customerRecord->id;
                    }
                    
                }else{
                    $customer_id = $data['customer_id'];
                }
                $input_array = [
                    "customer_id" => $customer_id,
                    "sub_customer_id" => isset($data['sub_customer_id']) ? $data['sub_customer_id'] : null,
                    "loctimestamp" => $geo_timestamp,
                    "amount" =>  $data['amount'],
                    "lat" =>  $location->coords->latitude,
                    "lng" =>  $location->coords->longitude,
                    "grand_total" =>  $data['total_amount'],
                    "sub_total" =>  $data['total_amount'],
                    "structure_id" =>  $data['structure_id'],
                    "stockist_id" =>  isset($data['stockist_id']) ? $data['stockist_id'] : null,
                    "photo" =>  isset($data['photo']) ? $data['photo'] : null,
                    "raise_stock" =>  isset($data['raise_stock']) ? $data['raise_stock'] : false,
                    "c_detail_uuid" =>  $c_detail_uuid,
                    'user_id' => $user_id,
                    'created_by' => $user_id,
                    'mocked' => $location->mocked,
                    'accuracy' => $location->coords->accuracy,
                    'raise_order' => $data['raise_order'],
                    'invoice_date' => $invoice_date,
                    'invoice_uuid' => $invoice_uuid,
                ];
                $Invoice = $this->model::create($input_array);
                DB::transaction(function () use ($input_array, $data, $Invoice) {

                    if ($Invoice) {
                        $product_codes = $data['product_code'];
                        $quantity = $data['quantity'];
                        $price = $data['price'];
                        $i = 0;

                        foreach($product_codes as $key => $item){
                            InvoiceDetail::create([
                                "invoice_id" => $Invoice->id,
                                "product_id" => $product_codes[$i],
                                "quantity" => $quantity[$i],
                                "price" => $price[$i],
                                "total_amount" => $price[$i]*$quantity[$i]
                            ]);
                            $i++;
                        }

                    }

                    // throw new \Exception('An error occured attempting to create Invoice');
                });
                return $Invoice;

            }catch(Exception $e){
                dd($e);
                abort(422, 'An error occured attempting to create Invoice');
            }
        }else{
            return $InvoiceModel->first();
        }
    }
    public function saveOption($data, $user_id){
        $status = "";
        $status_id = null;
        $other_reason = null;
        $completed_at = null;
        if(!isset($data['close_outlet'])){
            $start  = \Carbon\Carbon::createFromTimestamp($data['timestamp']/1000)->toDateTimeString();
            $position = (array)json_decode($data['position']);
            $position_cords = (array)$position['coords'];
            $closed_timestamp = \Carbon\Carbon::createFromTimestamp($data['close_timestamp']/1000)->toDateTimeString();
            $geo_timestamp = \Carbon\Carbon::createFromTimestamp($position['timestamp']/1000)->toDateTimeString();
            $status = 'Not Started';
            if($data['option']=="start"){
                $status = "Started Outlet";
                $current_status = "Started Outlet";
                $status_id = 6;
            }else if($data['option']=="closed"){
                $current_status = "Closed outlet";
                $status_id = 7;
                $completed_at = $closed_timestamp;
            }else if($data['option']=="cancelled"){
                $current_status = "Outlet data entry is cancelled";
                $status_id = 8;
            }else if($data['option']=="other"){
                $current_status = "Other reason";
                $status_id = 9;
                $other_reason = $data['otherreason'];
            }
            //handle closed
            if($data['closed']==1){
                $status = "Outlet marked as closed";
                $status_id = 7;
            }
            $input_arrray = [
                "user_id" => $user_id,
                "customer_id" => $data['customer_id'],
                "address" => isset($data['address']) ? $data['address'] : null,
                'started_timestamp' => $start,
                'status'=> $status,
                'other_reasons'=> $other_reason,
                'completed_timestamp'=> $closed_timestamp,
                'current_status_id'=> $status_id,
                'option_selected'=> $data['option'],
                'current_status'=> $current_status,
                'lat' => $position['coords']->latitude,
                'long' => $position['coords']->longitude,
                'accuracy' => $position['coords']->accuracy,
                'mocked' => $position['mocked'],
                'geotimestamp'=> $geo_timestamp,
                'option_uuid' =>$data['uuid']
            ];
            return DB::transaction(function () use ($input_arrray, $data) {
                $outlet_visit =OutletVisit::updateOrCreate(
                    ['option_uuid' => $input_arrray['option_uuid']],
                    $input_arrray
                );
                // $outlet_visit = OutletVisit::create($input_arrray);
                Customer::where('id', $data['customer_id'])->update(['visited_at'=> $input_arrray['completed_timestamp']]);
                $input_arr_copy = $input_arrray;
                if ($outlet_visit) {
                    $input_arr_copy['timestamp'] = $input_arrray['started_timestamp'];
                    UserLocationHistory::create($input_arr_copy);
                    $user_status = UserStatus::updateOrCreate(
                        ['user_id' => $input_arrray['user_id']],
                        $input_arrray
                    );
                }
                if ($outlet_visit) {
                    return $outlet_visit;
                }

                throw new \Exception('An error occured attempting to create visit');
            });
        }else{
            $end  = \Carbon\Carbon::createFromTimestamp($data['close_timestamp']/1000)->toDateTimeString();
            $outlet_visit_id = $data['outlet_visit_id'];
            $input_arrray = [
                'completed_timestamp'=> $end,
                'current_status_id'=> 10,
                'status' => "Closed Outlet",
            ];
            $outlet_visit = OutletVisit::find($outlet_visit_id);

            if($outlet_visit!=null){
                $outlet_visit->completed_timestamp = $end;
                $outlet_visit->status = "Completed";
                $outlet_visit = tap($outlet_visit)->save();
                $user_status = UserStatus::updateOrCreate(
                    ['user_id' => $user_id],
                    [
                        'customer_id' => null,
                        'current_status_id' => null,
                    ]
                );
                return $outlet_visit;
            }
            return null;
        }
    }
    public function updateOrder(array $data)
    {
        $structure_id = $data['structure_id'];
        $user_id = Auth::guard('api')->user()->id;
        $order = $data['order'];
        $cartItems = $data['cartItems'];
        $position = $data['position'];
        $address = $data['address'];
        $order_id = $order['id'];
        $invoice_details = $this->model::find($order_id);
        $order_exists = $this->model::where('order_id', $order_id)->count();
        if($order_exists){
            return $invoice_details;
        }
        try{

        $date = \Carbon\Carbon::createFromTimestamp($position['timestamp']/1000)->toDateTimeString();
        $totalAmount = 0;
        foreach($cartItems as $cartItem){
            $sub_total = $cartItem['price'] * $cartItem['quantity'];
            $totalAmount+=$sub_total;
        }
        $sub_customer_count = SubCustomer::where('id', $invoice_details->sub_customer_id)->count();
        // dd($totalAmount);
        $input_array = [
            "customer_id" => $order['customer_id'],
            "sub_customer_id" => $sub_customer_count > 0 ?$invoice_details->sub_customer_id : null,
            "stockist_id" => $invoice_details->stockist_id,
            "amount" =>  $totalAmount,
            "lat" =>  $position['coords']['latitude'],
            "lng" =>  $position['coords']['longitude'],
            "grand_total" =>  $totalAmount,
            "sub_total" =>  $totalAmount,
            "structure_id" =>  $data['structure_id'],
            "payment_method_id" => $order['payment_method_id'],
            "loctimestamp" => $date,
            'user_id' => $user_id,
            'created_by' => $user_id,
            'mocked' => $position['mocked'],
            'accuracy' => $position['coords']['accuracy'],
            'invoice_date' => $date,
            'order_id' => $order['id']
        ];

         DB::transaction(function () use ($input_array, $cartItems, $order, $user_id) {
            $Invoice = $this->model::create($input_array);

            if ($Invoice) {

                $i = 0;

                    foreach($cartItems as $key => $item){
                        InvoiceDetail::create([
                            "invoice_id" => $Invoice->id,
                            "product_id" => $item['product_id'],
                            "quantity" => $item['quantity'],
                            "price" => $item['price'],
                            "total_amount" => $item['price'] * $item['quantity']
                        ]);
                        $i++;
                    }

            $orderInvoice = $this->model::find($order['id']);
            $orderInvoice->is_approved = true;
            $orderInvoice->approved_by = $user_id;
            $orderInvoice->invoice_id = $Invoice->id;
            $orderInvoice->save();
            }
            return $Invoice;
            abort(422, 'An error occured attempting to create Invoice');
        });

        }catch(Exception $e){
            abort(422, 'An error occured attempting to create Invoice');
        }
    }
    public function confirmInvoiceOrder($id){
        $user_id = Auth::guard('api')->user()->id;
        $orderInvoice = $this->model::find($id);
        $orderInvoice->is_approved = true;
        $orderInvoice->approved_by = $user_id;
        $orderInvoice->save();
    }
    protected function InvoiceExists($name) : bool
    {
        return $this->model
            ->where('name', strtolower($name))
            ->count() > 0;
    }
    public function find($id) : Invoice
    {
        return $this->model->find($id);
    }
}

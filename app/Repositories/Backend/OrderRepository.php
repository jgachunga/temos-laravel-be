<?php

namespace App\Repositories\Backend;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Uom;
use App\Repositories\BaseRepository;
use Auth;
use Illuminate\Support\Facades\DB;

/**
 * Class OrderRepository
 * @package App\Repositories\Backend
 * @version October 28, 2019, 9:48 am UTC
*/

class OrderRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'structure_id',
        'order_ref',
        'pax',
        'total_amount',
        'discount',
        'amount_payable',
        'Order_id',
        'opened_by',
        'closed_by',
        'closed_at',
        'terminal_id',
        'shift_id',
        'is_printed',
        'is_active',
        'is_shown',
        'is_closed',
        'is_void',
        'display_name'
    ];


    public function __construct(Order $model)
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
    public function create(array $data) : Order
    {
        $structure_id = Auth::guard('api')->user()->logged_structure_id;
        if($structure_id==null){
            $structure_id = Auth::guard('api')->user()->structure_id;
        }
        $user_id = Auth::guard('api')->user()->id;
        $data['structure_id'] = $structure_id;
        $date = \Carbon\Carbon::createFromTimestamp($data['geotimestamp']/1000)->toDateTimeString();

        $input_array = [
            "customer_id" => $data['customer_id'],
            "printed" =>  $data['printed'],
            "amount" =>  $data['amount'][0],
            "lat" =>  $data['Latitude'],
            "lng" =>  $data['Longitude'],
            "address" =>  isset($data['address']) ? $data['address'] : null,
            'accuracy' => $data['accuracy'],
            'mocked' => $data['mocked'],
            'loctimestamp'=> $date,
            "total_amount" =>  $data['total_amount'],
            "structure_id" =>  $data['structure_id'],
            "payment_method_id" =>  $data['payment_method_id'],
            'user_id' => $user_id
        ];

        return DB::transaction(function () use ($input_array, $data) {
            $Order = $this->model::create($input_array);
            if ($Order) {
                $product_codes = $data['product_code'];
                $quantity = $data['quantity'];
                $price = $data['price'];
                $uoms = $data['uoms'];
                $i = 0;

                    foreach($product_codes as $key => $item){
                        $uom = Uom::where('name', $uoms[$i])->first();

                            OrderDetail::create([
                                "order_id" => $Order->id,
                                "product_code" => $product_codes[$i],
                                "product_id" => $product_codes[$i],
                                "quantity" => $quantity[$i],
                                "price" => $price[$i],
                                "uom_id" => $uom->id,
                                "total" => $price[$i]*$quantity[$i]
                            ]);

                        $i++;
                    }
                return $Order;
            }

            throw new \Exception('An error occured attempting to create Order');
        });
        }
        protected function OrderExists($name) : bool
        {
            return $this->model
                ->where('name', strtolower($name))
                ->count() > 0;
        }
        public function find($id) : Order
        {
            return $this->model->find($id);
        }
}

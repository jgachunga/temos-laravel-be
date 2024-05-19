<?php

namespace App\Repositories\Backend;

use App\Models\SubCustomer;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Class SubCustomerRepository
 * @package App\Repositories\Backend
 * @version April 25, 2021, 7:40 pm UTC
*/

class SubCustomerRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'rep_id',
        'reg_by_rep_id',
        'name',
        'phone_number',
        'email',
        'first_name',
        'last_name',
        'channel_id',
        'mocked',
        'gpstimestamp',
        'description',
        'lat',
        'lng',
        'accuracy',
        'speed',
        'heading'
    ];

    public function __construct(SubCustomer $model)
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
    public function create(array $data) : SubCustomer
    {
        $structure_id = Auth::guard('api')->user()->logged_structure_id;
        if($structure_id==null){
            $structure_id = Auth::guard('api')->user()->structure_id;
        }
        $data['structure_id'] = $structure_id;
        // Make sure it doesn't already exist
        if ($this->SubCustomerExists($data)) {
            abort(422, 'A SubCustomer already exists with the name '.e($data['name']));
        }

        return DB::transaction(function () use ($data) {
            $sub_customer = $this->model::create($data);

            if ($sub_customer) {
                return $sub_customer;
            }

            abort(422, 'An error occured attempting to create sub_customer');
        });
    }
    public function createApi(array $data) : SubCustomer
    {
        \Log::debug($data);
        $user_id = Auth::guard('api')->user()->id;
        if(!isset($data['route_id'])){
            $data['route_id'] = Auth::guard('api')->user()->route_id;
            }
        $rep_id = Auth::guard('api')->user()->rep_id;

        $input_array = [
            "name" => $data['name'],
            "sub_domain" =>  isset($data['sub_domain']) ? $data['sub_domain'] : null,
            "address" =>  isset($data['address']) ? $data['address'] : null,
            "country" =>  isset($data['country']) ? $data['country'] : null,
            "first_name" =>  isset($data['first_name']) ? $data['first_name'] : null ,
            "last_name" =>  isset($data['last_name']) ?$data['last_name'] : null,
            "email" =>  isset($data['email']) ? $data['email'] :null,
            "phone_number" =>  isset($data['phone_number']) ? $data['phone_number'] :null,
            "channel_id" =>  isset($data['channel']) ? $data['channel'] :null,
            "structure_id" =>  $data['structure_id'],
            "user_id" =>  $user_id,
            "rep_id" =>  $rep_id,
            "route_id" =>  $data['route_id'],
            "geoaddress" => isset($data['geoaddress']) ? $data['geoaddress'] :null,
            "mocked" =>  isset($data['position']) ? $data['position']['mocked'] : null,
            "gpstimestamp" => isset($data['position']) ? $data['position']['timestamp'] : null,
            "speed" =>  isset($data['position']) ? $data['position']['coords']['speed'] : null,
            "heading" =>  isset($data['position']) ? $data['position']['coords']['heading'] : null,
            "accuracy" => isset($data['position']) ? round($data['position']['coords']['accuracy'],6) : null,
            "lat" =>  isset($data['position']) ? $data['position']['coords']['latitude'] : null,
            "lng" =>  isset($data['position']) ? $data['position']['coords']['longitude'] : null,
            "customer_id" =>$data['customer_id']

        ];

        // Make sure it doesn't already exist
        // if ($this->CustomerExists($data)) {
        //     throw new \Exception('A Customer already exists with the name '.e($data['name']));
        // }

        return DB::transaction(function () use ($input_array, $data) {
            $Customer = $this->model::create($input_array);

            // if ($Customer) {
            //     $customer_sale_structures = collect($data['structure_ids']);
            //     $customer_sale_structures->map(function ($structure_id) use($Customer){
            //         CustomerSaleStructrure::create([
            //             "cust_id" => $Customer->id,
            //             "structure_id" => $structure_id
            //         ]);
            //         return true;
            //     });
            //     $this->registerCustomerUser($Customer);
            //     return $Customer;
            // }
            return $Customer;
            throw new \Exception('An error occured attempting to create Customer');
        });
    }
    public function updateApi(array $data, int $id) : SubCustomer
    {
        $structure_id = Auth::guard('api')->user()->logged_structure_id;
        if($structure_id==null){
            $structure_id = Auth::guard('api')->user()->structure_id;
        }
        $user_id = Auth::guard('api')->user()->id;
        $customer = $this->model->find($id);
        $route_id = $this->getRoute($user_id);
        $rep_id = Auth::guard('api')->user()->rep_id;
        $data['structure_id'] = $structure_id;

        $input_array = [
            "name" => $data['name'],
            "sub_domain" =>  $data['sub_domain'],
            "address" =>  $data['address'],
            "country" =>  $data['country'],
            "first_name" =>  $data['first_name'],
            "last_name" =>  $data['last_name'],
            "email" =>  $data['email'],
            "phone_number" =>  $data['phone_number'],
            "channel_id" =>  $data['channel'],
            "structure_id" =>  $structure_id,
            "user_id" =>  $user_id,
            "rep_id" =>  $rep_id,
            "route_id" =>  $route_id,
            "geoaddress" => $data['geoaddress'],
            "mocked" =>  $data['position']['mocked'],
            "gpstimestamp" =>  $data['position']['timestamp'],
            "speed" =>  $data['position']['coords']['speed'],
            "heading" =>  $data['position']['coords']['heading'],
            "accuracy" =>  round($data['position']['coords']['accuracy'],6),
            "lat" =>  $data['position']['coords']['latitude'],
            "lng" =>  $data['position']['coords']['longitude'],
            "customer_id" =>$data['customer_id']

        ];
        // Make sure it doesn't already exist
        // if ($this->CustomerExists($data)) {
        //     throw new \Exception('A Customer already exists with the name '.e($data['name']));
        // }

        return DB::transaction(function () use ($input_array, $data, $route_id, $id) {
            $SubCustomer = $this->model->find($id);
            $SubCustomer = tap($SubCustomer)->update($input_array);
            return $SubCustomer;
            throw new \Exception('An error occured attempting to update Customer');
        });
    }
        protected function SubCustomerExists($data) : bool
        {
            return $this->model
                ->where('name', strtolower($data['name']))
                ->where('structure_id', strtolower($data['structure_id']))
                ->count() > 0;
        }
        public function find($id) : SubCustomer
        {
            return $this->model->find($id);
        }
}

<?php

namespace App\Repositories\Backend;

use App\Models\Customer;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;
use App\Models\CustomerSaleStructrure;
use Hash;
use App\Models\Auth\User;
use App\Models\Route;
use App\Models\SubCustomer;
use App\Models\Town;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

/**
 * Class CustomerRepository
 * @package App\Repositories\Backend
 * @version October 26, 2019, 5:06 am UTC
*/

class CustomerRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'rep_id',
        'reg_by_rep_id',
        'name',
        'phone',
        'description',
        'lat',
        'lng',
        'accuracy'
    ];

    public function __construct(Customer $model)
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
    public function create(array $data) : Customer
    {
        $structure_id = Auth::guard('api')->user()->logged_structure_id;
        if($structure_id==null){
            $structure_id = Auth::guard('api')->user()->structure_id;
        }
        $user_id = Auth::guard('api')->user()->id;
        $route_id = Auth::guard('api')->user()->route_id;
        $input_array=[];

        // Make sure it doesn't already exist

        $input_array = [
            "name" => $data['name'],
            "address" =>  $data['address']['address'],
            "email" =>  $data['email'],
            "phone_number" =>  $data['phone'],
            "channel_id" =>  $data['channel'],
            "route_id" =>  $route_id,
            "type_id" =>  $data['type'],
            "lat" =>  $data['address']['latLng']['lat'],
            "lng" =>  $data['address']['latLng']['lng'],
        ];
        $input_array['structure_id'] = $structure_id;
        $input_array['user_id'] = $user_id;

        if ($this->CustomerExists($input_array)) {
            throw new \Exception('A Customer already exists with the name '.e($data['name']));
        }
        return DB::transaction(function () use ($input_array) {
            $Customer = $this->model::create($input_array);

            if ($Customer) {
                return $Customer;
            }

            throw new \Exception('An error occured attempting to create Customer');
        });
    }

    public function createApi(array $data) : Customer
    {
        \Log::debug($data);
        $user_id = Auth::guard('api')->user()->id;
        $structure_id = Auth::guard('api')->user()->logged_structure_id;
        if($structure_id==null){
            $structure_id = Auth::guard('api')->user()->structure_id;
        }
        if(!isset($data['route_id'])){
            $data['route_id'] = Auth::guard('api')->user()->route_id;
            }
        $rep_id = Auth::guard('api')->user()->rep_id;
        $visitedAt = null;
        $custUuid = isset($data['uuid']) ? $data['uuid'] : '';

        $customerExixts = Customer::where('uuid', $custUuid)->first();
        if($customerExixts){
            return $customerExixts;
        }
        if(isset($data['visited_at']) && $data['visited_at']!='null'){
            $visitedAt = \Carbon\Carbon::createFromFormat('D M d Y H:i:s e+',$data['visited_at'])->toDateTimeString();
        }

        $input_array = [
            "name" => $data['name'],
            "uuid" => isset($data['uuid']) ? $data['uuid'] : null,
            "sub_domain" =>  isset($data['sub_domain']) ? $data['sub_domain'] : null,
            "address" =>  isset($data['address']) ? $data['address'] : null,
            "country" =>  isset($data['country']) ? $data['country'] : null,
            "first_name" =>  isset($data['first_name']) ? $data['first_name'] : null ,
            "last_name" =>  isset($data['last_name']) ?$data['last_name'] : null,
            "email" =>  isset($data['email']) ? $data['email'] :null,
            "phone_number" =>  isset($data['phone_number']) ? $data['phone_number'] :null,
            "channel_id" =>  isset($data['channel_id']) ? $data['channel_id'] :null,
            "structure_id" =>  $structure_id,
            "user_id" =>  $user_id,
            "rep_id" =>  $rep_id,
            "route_id" =>  $data['route_id'],
            "geoaddress" => isset($data['geoaddress']) ? $data['geoaddress'] :null,
            "mocked" =>  isset($data['mocked']) ? filter_var($data['mocked'], FILTER_VALIDATE_BOOLEAN) : null,
            "gpstimestamp" => isset($data['timestamp']) ? $data['timestamp'] : null,
            "accuracy" => isset($data['accuracy']) ? round($data['accuracy'],6) : null,
            "lat" =>  isset($data['lat']) ? $data['lat'] : null,
            "lng" =>  isset($data['lat']) ? $data['lng'] : null,
            "visited_at" => $visitedAt,
        ];

        return DB::transaction(function () use ($input_array, $data, $structure_id) {
            if(isset($data['address'])){
            $town = Town::where('name', $data['address'])->first();
            if($town!=null){
                $town_id = $town->id;
            }else{

                $town = Town::create([
                    "name" => $data['address'],
                    "route_id" => $data['route_id']
                ]);
                $town_id = $town->id;

                }
                $input_array['town_id'] = $town_id ? $town_id : null;
            }
            $Customer = $this->model::create($input_array);

            if($Customer){
                $subCustomers = json_decode($data['subCustomers']);
                foreach($subCustomers as $subCustomer){
                    $subCustomer = SubCustomer::create([
                        "name" => $subCustomer->name,
                        "phone_number" => $subCustomer->phone_number,
                        "customer_id" => $Customer->id,
                        "structure_id" => $structure_id
                    ]);
                }
                return $Customer;
            }
            throw new \Exception('An error occured attempting to create Customer');
        });
    }
    public function updateApi(array $data, int $id) : Customer
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
        $visitedAt = null;
        if(isset($data['visited_at']) && $data['visited_at']!='null'){
            $visitedAt = \Carbon\Carbon::createFromFormat('D M d Y H:i:s e+',$data['visited_at'])->toDateTimeString();
        }
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
            "visited_at" => $visitedAt,
        ];

        // Make sure it doesn't already exist
        // if ($this->CustomerExists($data)) {
        //     throw new \Exception('A Customer already exists with the name '.e($data['name']));
        // }

        return DB::transaction(function () use ($input_array, $data, $route_id, $id) {
            $town = Town::where('name', $data['address'])->first();
            if($town!=null){
                $town_id = $town->id;
            }else{
                $town = Town::create([
                    "name" => $data['address'],
                    "route_id" => $route_id
                ]);
                $town_id = $town->id;
            }
            $input_array['town_id'] = $town_id;
            $Customer = $this->model->find($id);
            $Customer = tap($Customer)->update($input_array);
            return $Customer;
            throw new \Exception('An error occured attempting to update Customer');
        });
    }
    protected function CustomerExists($data) : bool
    {
        return $this->model
            ->where('name', strtolower($data['name']))
            ->where('structure_id', strtolower($data['structure_id']))
            ->count() > 0;
    }
    public function find($id) : Customer
    {
        return $this->model->find($id);
    }
    public function registerCustomerUser (Customer $customer) {
        $name = $customer->name;

        $input_array=["username" => $name, "phone" => $customer->phone_number, "email" => $customer->email, 'is_customer' => true, 'cust_id' => $customer->id, ];
        $token = mt_rand(100000, 999999);
        $input_array['password']=Hash::make($token);
        $user = User::create($input_array);
        $customer->user_id = $user->id;
        $customer->save();
        $user->sendCustomerToken($input_array['phone'], $token);
        $success_obj=array('Code' => 201,'Status'=>'Success','Message'=> 'Message sent successfully' );
        return response()->json($success_obj);

    }
    public function getRoute($user_id){
        $date = Carbon::now()->toArray();
        $day_of_week = $date['dayOfWeek'];
        $route_id = Route::where('user_id' ,$user_id)->where("route_pjp", $day_of_week)->pluck('id')->first();
        return $route_id;
    }
    public function getbyRouteId($route_id)
    {
        $customers = $this->model::where('route_id', $route_id)
        ->with('channel', 'route', 'sub_customers')
        ->orderByDesc('created_at')
        ->get();
        return $customers;
    }
}

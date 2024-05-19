<?php

namespace App\Repositories\Backend;

use App\Models\Product;
use App\Models\Channel;
use App\Models\ProductPrice;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;
use App\Exceptions\GeneralException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

/**
 * Class ProductRepository
 * @package App\Repositories\Backend
 * @version September 24, 2019, 12:04 pm UTC
*/

class ProductRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'code',
        'desc',
        'cat_id',
        'price',
        'img_url',
        'client_id',
        'discount'
    ];

    public function __construct(Product $model)
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
    public function create(array $data) : Product
    {
        // Make sure it doesn't already exist
        return DB::transaction(function () use ($data) {
            $user = Auth::guard('api')->user();
            Log::debug($user);
            $input_array = [];
            if($user->logged_structure_id!=null){
                $input_array['structure_id'] = $user->logged_structure_id;
            }else{
                $input_array['structure_id'] = $user->structure_id;
            }
            $input_array['name'] = $data['name'];
            $input_array['code'] = isset($data['code']) ? $data['code'] : null;
            $input_array['desc'] = isset($data['desc']) ? $data['desc'] : null;
            $input_array['cat_id'] = isset($data['cat_id']) ? $data['cat_id'] : null;

            $product = $this->model::create($input_array);
            if ($product) {
                foreach(json_decode($data['prices']) as $key => $price){
                    $exists = ProductPrice::where("channel_id", $price->id)->where('product_id', $product->id)->first();
                    if($exists==null){
                        ProductPrice::create(['product_id' =>$product->id, "channel_id"=>  $price->id, 'price' => $price->price]);
                    }
                }
                return $product;
            }

        });
    }
    public function update(array $data, $id) : Product
    {
        // Make sure it doesn't already exist
        return DB::transaction(function () use ($data, $id) {
            $user = Auth::guard('api')->user();
            Log::debug($data);
            $input_array = [];
            $product = $this->find($id);
            $product->name = $data['name'];
            $product->name = isset($data['code']) ? $data['code'] : null;
            $product->cat_id = isset($data['cat_id']) ? $data['cat_id'] : null;
            if ($product) {
                foreach(json_decode($data['prices']) as $key => $price){
                    $exists = ProductPrice::where("channel_id", $price->id)->where('product_id', $product->id)->first();
                    if($exists==null){
                        ProductPrice::create(['product_id' =>$product->id, "channel_id"=>  $price->id, 'price' => $price->price]);
                    }else{
                        $exists->price = $price->price;
                        $exists->save();
                    }
                }
                return $product;
            }

        });
    }
    protected function ProductExists($name) : bool
    {
        return $this->model
            ->where('name', strtolower($name))
            ->count() > 0;
    }
    public function find($id) : Product
    {
        return $this->model->find($id);
    }
}

<?php

namespace App\Repositories\Backend;

use App\Models\CustomerDetail;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Class CustomerDetailRepository
 * @package App\Repositories\Backend
 * @version January 22, 2023, 9:01 pm UTC
*/

class CustomerDetailRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'customer_id',
        'started',
        'ended',
        'activeDate',
        'category',
        'status'
    ];

    public function __construct(CustomerDetail $model)
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
    public function create(array $data)
    {
        foreach($data as $customerDetail){
            $started = null;
            $ended = null;
            $user_id = Auth::guard('api')->user()->id;
            $activeDate = \Carbon\Carbon::createFromFormat('D M d Y H:i:s e+',$customerDetail['activeDate'])->toDateTimeString();
            if($customerDetail['started'] != null){
                $started = \Carbon\Carbon::createFromFormat('D M d Y H:i:s e+',$customerDetail['started'])->toDateTimeString();
            }
            if($customerDetail['ended'] != null){
                $ended = \Carbon\Carbon::createFromFormat('D M d Y H:i:s e+',$customerDetail['ended'])->toDateTimeString();
            }

            $exists = $this->CustomerDetailExists($customerDetail, $activeDate);

            if ($exists) {
              $exists->started = $started;
              $exists->ended = $ended;
              $exists->status = $customerDetail['status'];
              $exists->sales = $customerDetail['sales'];
              $exists->orders = $customerDetail['orders'];
              $exists->category = $customerDetail['category'];
              $exists->activeDate = $activeDate;
              $exists->reason = isset($customerDetail['reason']) ? $customerDetail['reason'] : null;
              $exists->save();
            }else{
                $inputArr = [
                    'user_id' => $user_id,
                    'c_detail_uuid' => isset($customerDetail['c_detail_uuid']) ? $customerDetail['c_detail_uuid'] : null,
                    'customer_uuid' => isset($customerDetail['uuid']) ? $customerDetail['uuid'] : null,
                    'sales' => isset($customerDetail['sales']) ? $customerDetail['sales'] : null,
                    'orders' => isset($customerDetail['orders']) ? $customerDetail['orders'] : null,
                    'customer_id' => $customerDetail['customer_id'],
                    'uuid' => $customerDetail['uuid'],
                    'started' => $started,
                    'ended' => $ended,
                    'status' => $customerDetail['status'],
                    'reason' => isset($customerDetail['reason']) ? $customerDetail['reason'] : null,
                    'category' => $customerDetail['category'],
                    'activeDate' => $activeDate,
                ];

                $customerDetail = $this->model::create($inputArr);
            }

        }
        // Make sure it doesn't already exist
        }

        protected function CustomerDetailExists($data)
        {

            return $this->model
                ->where('c_detail_uuid', $data['c_detail_uuid'])
                ->first();
        }
        public function find($id) : CustomerDetail
        {
            return $this->model->find($id);
        }
}


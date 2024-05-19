<?php

namespace App\Repositories\Backend;

use App\Models\Customer;
use App\Models\FormsAnswered;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;

/**
 * Class FormsAnsweredRepository
 * @package App\Repositories\Backend
 * @version February 19, 2020, 2:12 pm UTC
*/

class FormsAnsweredRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'form_id',
        'user_id',
        'customer_id',
        'c_detail_uuid',
        'stockist_id',
        'status_id',
        'status',
        'reason',
        'other_reasons',
        'has_answers',
        'start',
        'end',
        'duration',
        'lat',
        'long',
        'accuracy',
        'latitude',
        'mocked',
        'geotimestamp'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function __construct(FormsAnswered $model)
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
        foreach($data as $FormsAnswered){
            $user_id = Auth::guard('api')->user()->id;
            $questionCount = $FormsAnswered['questionFormCount'] != 'undefined' ? $FormsAnswered['questionFormCount'] : null;
            $customer_id = null;
            if($FormsAnswered['customer_id'] == null || $FormsAnswered['customer_id'] == 'null'){
                $customerRecord = Customer::where('uuid', $FormsAnswered['uuid'])->first();
                $customer_id = $customerRecord->id;
            }else{
                $customer_id = $FormsAnswered['customer_id'];
            }
            $exists = $this->FormsAnsweredExists($FormsAnswered, $user_id, $customer_id);
            if ($exists) {
              $exists->answered = $FormsAnswered['answered'];
              $exists->uploaded = $FormsAnswered['uploaded'];
              $exists->photos = $FormsAnswered['photos'];
              $exists->stockist_id = $FormsAnswered['stockist_id'];
              $exists->questionCount = $questionCount;
              $exists->uploadedPhotos = $FormsAnswered['uploadedPhotos'];
              $exists->save();
            }else{
                $inputArr = [
                    'customer_id' => $customer_id,
                    'user_id' => $user_id,
                    'status_id' => 1,
                    'uuid' => $FormsAnswered['uuid'],
                    'c_detail_uuid' => isset($FormsAnswered['c_detail_uuid']) ? $FormsAnswered['c_detail_uuid'] : null,
                    'stockist_id' => isset($FormsAnswered['stockist_id']) ? $FormsAnswered['stockist_id'] : null,
                    'questionCount' => $questionCount,
                    'answered' => $FormsAnswered['answered'],
                    'form_id' => $FormsAnswered['form_id'],
                    'uploaded' => $FormsAnswered['uploaded'],
                    'photos' => $FormsAnswered['photos'],
                    'uploadedPhotos' => $FormsAnswered['uploadedPhotos'],
                ];

                $FormsAnswered = $this->model::create($inputArr);
            }

        }
        // Make sure it doesn't already exist
        }

        protected function FormsAnsweredExists($data, $user_id, $customer_id)
        {
            return $this->model
                ->where('customer_id', $customer_id)
                ->where('form_id', $data['form_id'])
                ->where('user_id', $user_id)
                ->first();
        }
        public function find($id) : FormsAnswered
        {
            return $this->model->find($id);
        }
}

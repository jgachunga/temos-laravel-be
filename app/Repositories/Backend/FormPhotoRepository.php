<?php

namespace App\Repositories\Backend;

use App\Models\Customer;
use App\Models\FormPhoto;
use App\Models\FormsAnswered;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;

/**
 * Class FormPhotoRepository
 * @package App\Repositories\Backend
 * @version January 22, 2023, 9:02 pm UTC
*/

class FormPhotoRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'form_answered_id',
        'question_id',
        'image_url'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function __construct(FormPhoto $model)
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
        foreach($data as $FormsPhoto){
            $user_id = Auth::guard('api')->user()->id;

            if($FormsPhoto['customer_id'] == null || $FormsPhoto['customer_id'] == 'null'){
                $customerRecord = Customer::where('uuid', $FormsPhoto['uuid'])->first();
                $customer_id = $customerRecord->id;
            }else{
                $customer_id = $FormsPhoto['customer_id'];
            }
            $formAnswered = $this->FormAnswered($FormsPhoto, $user_id, $customer_id);
            if($formAnswered){

                $inputArr = [
                    'question_id' => $FormsPhoto['question_id'],
                    'image_url' => $FormsPhoto['photo'],
                    'form_answered_id' => $formAnswered->id,
                    'customer_id' => $customer_id
                ];

                $formsPhoto = $this->model::create($inputArr);

            }
        }
        // Make sure it doesn't already exist
    }

    protected function FormAnswered($data, $user_id, $customer_id)
    {
        return FormsAnswered::
                where('customer_id', $customer_id)
            ->where('form_id', $data['form_id'])
            ->where('user_id', $user_id)
            ->first();
    }
    public function find($id) : FormPhoto
    {
        return $this->model->find($id);
    }
}

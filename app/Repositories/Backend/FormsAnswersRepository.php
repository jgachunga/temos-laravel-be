<?php

namespace App\Repositories\Backend;

use App\Models\FormsAnswered;
use App\Models\FormsAnswers;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;

/**
 * Class FormsAnswersRepository
 * @package App\Repositories\Backend
 * @version February 19, 2020, 2:13 pm UTC
*/

class FormsAnswersRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'form_answered_id',
        'question_id',
        'question_type',
        'answer',
        'target',
        'diff',
        'answer_timestamp',
        'image_url'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function __construct(FormsAnswers $model)
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
        foreach($data as $FormsAnswers){
            $user_id = Auth::guard('api')->user()->id;

            $formAnswered = $this->FormAnswered($FormsAnswers, $user_id);
            if($formAnswered){
            $exists = $this->FormsAnswersExists($FormsAnswers, $formAnswered->id);

            if ($exists) {
              $exists->answer = $FormsAnswers['answer'];
              $exists->save();
            }else{
                $inputArr = [
                    'question_id' => $FormsAnswers['question_id'],
                    'c_detail_uuid' => isset($FormsAnswers['c_detail_uuid']) ? $FormsAnswers['c_detail_uuid'] : null,
                    'answer' => $FormsAnswers['answer'],
                    'form_answered_id' => $formAnswered->id,
                ];

                $FormsAnswers = $this->model::create($inputArr);
            }
            }
        }
        // Make sure it doesn't already exist
        }

        protected function FormAnswered($data, $user_id)
        {
            return FormsAnswered::
                 where('customer_id', $data['customer_id'])
                ->where('form_id', $data['form_id'])
                ->where('user_id', $user_id)
                ->first();
        }
        protected function FormsAnswersExists($data, $form_answered_id)
        {
            return $this->model
                ->where('question_id', $data['question_id'])
                ->where('form_answered_id', $form_answered_id)
                ->first();
        }
        public function find($id) : FormsAnswers
        {
            return $this->model->find($id);
        }
}

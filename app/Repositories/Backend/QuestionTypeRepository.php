<?php

namespace App\Repositories\Backend;

use App\Models\QuestionType;
use App\Repositories\BaseRepository;

/**
 * Class QuestionTypeRepository
 * @package App\Repositories\Backend
 * @version July 24, 2021, 8:53 pm EAT
*/

class QuestionTypeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'question_type'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    public function __construct(QuestionType $model)
    {
        $this->model = $model;
    }

    /**
     * Configure the Model
     **/
    public function create(array $data) : QuestionType
    {
        $structure_id = Auth::guard('api')->user()->logged_structure_id;
        if($structure_id==null){
            $structure_id = Auth::guard('api')->user()->structure_id;
        }
        $data['structure_id'] = $structure_id;
        // Make sure it doesn't already exist
        if ($this->QuestionTypeExists($data)) {
            throw new \Exception('A QuestionType already exists with the name '.e($data['name']));
        }

        return DB::transaction(function () use ($data) {
            $QuestionType = $this->model::create($data);

            if ($QuestionType) {
                return $QuestionType;
            }

            throw new \Exception('An error occured attempting to create QuestionType');
        });
        }
        protected function QuestionTypeExists($data) : bool
        {
            return $this->model
                ->where('name', strtolower($data['name']))
                ->where('structure_id', strtolower($data['structure_id']))
                ->count() > 0;
        }
        public function find($id) : QuestionType
        {
            return $this->model->find($id);
        }
}

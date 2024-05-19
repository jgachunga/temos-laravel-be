<?php

namespace App\Repositories\Backend;

use App\Models\SkipOption;
use App\Repositories\BaseRepository;

/**
 * Class SkipOptionRepository
 * @package App\Repositories\Backend
 * @version July 24, 2021, 8:47 pm EAT
*/

class SkipOptionRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'condition'
    ];

    public function __construct(SkipOption $model)
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
    public function create(array $data) : SkipOption
    {
        $structure_id = Auth::guard('api')->user()->logged_structure_id;
        if($structure_id==null){
            $structure_id = Auth::guard('api')->user()->structure_id;
        }
        $data['structure_id'] = $structure_id;
        // Make sure it doesn't already exist
        if ($this->SkipOptionExists($data)) {
            throw new \Exception('A SkipOption already exists with the name '.e($data['name']));
        }

        return DB::transaction(function () use ($data) {
            $SkipOption = $this->model::create($data);

            if ($SkipOption) {
                return $SkipOption;
            }

            throw new \Exception('An error occured attempting to create SkipOption');
        });
        }
        protected function SkipOptionExists($data) : bool
        {
            return $this->model
                ->where('name', strtolower($data['name']))
                ->where('structure_id', strtolower($data['structure_id']))
                ->count() > 0;
        }
        public function find($id) : SkipOption
        {
            return $this->model->find($id);
        }
}

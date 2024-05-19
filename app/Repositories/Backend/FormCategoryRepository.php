<?php

namespace App\Repositories\Backend;

use App\Exceptions\GeneralException;
use App\Models\FormCategory;
use App\Repositories\BaseRepository;
use Auth;
use DB;

/**
 * Class FormCategoryRepository
 * @package App\Repositories\Backend
 * @version March 1, 2020, 10:42 am EAT
*/

class FormCategoryRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function __construct(FormCategory $model)
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
    public function create(array $data) : FormCategory
    {
        $structure_id = Auth::guard('api')->user()->logged_structure_id;
        if($structure_id==null){
            $structure_id = Auth::guard('api')->user()->structure_id;
        }
        $data['structure_id'] = $structure_id;
        // Make sure it doesn't already exist
        if ($this->FormCategoryExists($data)) {
            throw new GeneralException('A FormCategory already exists with the name '.e($data['name']));
        }

        return DB::transaction(function () use ($data) {
            $FormCategory = $this->model::create($data);

            if ($FormCategory) {
                return $FormCategory;
            }

            throw new GeneralException('An error occured attempting to create FormCategory');
        });
    }
    public function updateStatus(array $data, $id)
    {

        return DB::transaction(function () use ($data, $id) {
            $FormCategory = $this->model->find($id);
            $FormCategory->active = $data['active'];
            $FormCategory->save();

            if ($FormCategory) {
                return $FormCategory;
            }

            abort(422, 'An error occured attempting to create FormCategory');
        });
    }

    protected function FormCategoryExists($data) : bool
    {
        return $this->model
            ->where('name', strtolower($data['name']))
            ->where('structure_id', strtolower($data['structure_id']))
            ->count() > 0;
    }
    public function find($id) : FormCategory
    {
        return $this->model->find($id);
    }
}

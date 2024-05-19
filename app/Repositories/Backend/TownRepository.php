<?php

namespace App\Repositories\Backend;

use App\Models\Town;
use App\Repositories\BaseRepository;
use Auth;
use DB;

/**
 * Class TownRepository
 * @package App\Repositories\Backend
 * @version March 6, 2020, 10:04 am EAT
*/

class TownRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'route_id',
        'name',
        'desc'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function __construct(Town $model)
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
    public function create(array $data) : Town
    {
        $structure_id = Auth::guard('api')->user()->logged_structure_id;
        if($structure_id==null){
            $structure_id = Auth::guard('api')->user()->structure_id;
        }
        // $data['structure_id'] = $structure_id;
        // Make sure it doesn't already exist
        if ($this->TownExists($data)) {
            throw new \Exception('A Town already exists with the name '.e($data['name']));
        }

        return DB::transaction(function () use ($data) {
            $Town = $this->model::create($data);

            if ($Town) {
                return $Town;
            }

            throw new \Exception('An error occured attempting to create Town');
        });
        }
        protected function TownExists($data) : bool
        {
            return $this->model
                ->where('name', strtolower($data['name']))
                ->count() > 0;
        }
        public function find($id) : Town
        {
            return $this->model->find($id);
        }
}


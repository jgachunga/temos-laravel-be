<?php

namespace App\Repositories\Backend;

use App\Models\Principals;
use App\Repositories\BaseRepository;
use Auth;
use DB;

/**
 * Class PrincipalsRepository
 * @package App\Repositories\Backend
 * @version February 29, 2020, 10:54 am EAT
*/

class PrincipalsRepository extends BaseRepository
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
    public function __construct(Principals $model)
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
    public function create(array $data) : Principals
    {
        $structure_id = Auth::guard('api')->user()->logged_structure_id;
        if($structure_id==null){
            $structure_id = Auth::guard('api')->user()->structure_id;
        }
        // $data['structure_id'] = $structure_id;
        // Make sure it doesn't already exist
        if ($this->PrincipalsExists($data)) {
            throw new \Exception('A Principals already exists with the name '.e($data['name']));
        }

        return DB::transaction(function () use ($data) {
            $Principals = $this->model::create($data);

            if ($Principals) {
                return $Principals;
            }

            throw new \Exception('An error occured attempting to create Principals');
        });
        }
        protected function PrincipalsExists($data) : bool
        {
            return $this->model
                ->where('name', strtolower($data['name']))
                // ->where('structure_id', strtolower($data['structure_id']))
                ->count() > 0;
        }
        public function find($id) : Principals
        {
            return $this->model->find($id);
        }
}

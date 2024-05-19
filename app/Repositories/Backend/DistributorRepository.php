<?php

namespace App\Repositories\Backend;

use App\Models\Distributor;
use Illuminate\Support\Facades\DB;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;
/**
 * Class DistributorRepository
 * @package App\Repositories\Backend
 * @version September 22, 2019, 5:23 am UTC
*/

class DistributorRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'description'
    ];

    public function __construct(Distributor $model)
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
    public function create(array $data) : Distributor
    {
        $structure_id = Auth::guard('api')->user()->logged_structure_id;
        if($structure_id==null){
            $structure_id = Auth::guard('api')->user()->structure_id;
        }
        $data['structure_id'] = $structure_id;
        // Make sure it doesn't already exist
        if ($this->distributorExists($data['name'])) {
            throw new \Exception('A distributor already exists with the name '.e($data['name']));
        }

        return DB::transaction(function () use ($data) {
            $client = $this->model::create($data);

            if ($client) {
                return $client;
            }

            throw new \Exception('An error occured attempting to create client');
        });
    }
    protected function distributorExists($name) : bool
    {
        return $this->model
            ->where('name', strtolower($name))
            ->count() > 0;
    }
    public function find($id) : Distributor
    {
        return $this->model->find($id);
    }
}

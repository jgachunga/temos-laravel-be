<?php

namespace App\Repositories\Backend;

use App\Models\Client;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Class ClientRepository
 * @package App\Repositories\Backend
 * @version September 24, 2019, 10:11 am UTC
*/

class ClientRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'description',
        'address',
        'user_id'
    ];

    public function __construct(Client $model)
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
    public function create(array $data) : Client
    {
        $structure_id = Auth::guard('api')->user()->logged_structure_id;
        if($structure_id==null){
            $structure_id = Auth::guard('api')->user()->structure_id;
        }
        $data['structure_id'] = $structure_id;
        // Make sure it doesn't already exist
        if ($this->ClientExists($data)) {
            throw new \Exception('A Client already exists with the name '.e($data['name']));
        }

        return DB::transaction(function () use ($data) {
            $client = $this->model::create($data);

            if ($client) {
                return $client;
            }

            throw new \Exception('An error occured attempting to create client');
        });
        }
        protected function ClientExists($data) : bool
        {
            return $this->model
                ->where('name', strtolower($data['name']))
                ->where('structure_id', strtolower($data['structure_id']))
                ->count() > 0;
        }
        public function find($id) : Client
        {
            return $this->model->find($id);
        }
}

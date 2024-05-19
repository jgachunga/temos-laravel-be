<?php

namespace App\Repositories\Backend;

use App\Models\UserClient;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;

/**
 * Class UserClientRepository
 * @package App\Repositories\Backend
 * @version January 8, 2023, 11:13 am UTC
*/

class UserClientRepository extends BaseRepository
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

    public function __construct(UserClient $model)
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
    public function create(array $data) : UserClient
    {
        $structure_id = Auth::guard('api')->user()->logged_structure_id;
        if($structure_id==null){
            $structure_id = Auth::guard('api')->user()->structure_id;
        }
        $data['structure_id'] = $structure_id;
        // Make sure it doesn't already exist
        if ($this->UserClientExists($data)) {
            throw new \Exception('A UserClient already exists with the name '.e($data['name']));
        }

        return DB::transaction(function () use ($data) {
            $UserClient = $this->model::create($data);

            if ($UserClient) {
                return $UserClient;
            }

            throw new \Exception('An error occured attempting to create UserClient');
        });
        }
        protected function UserClientExists($data) : bool
        {
            return $this->model
                ->where('name', strtolower($data['name']))
                ->where('structure_id', strtolower($data['structure_id']))
                ->count() > 0;
        }
        public function find($id) : UserClient
        {
            return $this->model->find($id);
        }
}

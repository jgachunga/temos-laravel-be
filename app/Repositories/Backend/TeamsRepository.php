<?php

namespace App\Repositories\Backend;

use App\Models\Auth\User;
use App\Models\Teams;
use App\Models\TeamUser;
use App\Repositories\BaseRepository;
use Auth;
use DB;

/**
 * Class TeamsRepository
 * @package App\Repositories\Backend
 * @version February 29, 2020, 10:54 am EAT
*/

class TeamsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'supervisor_id',
        'name',
        'structure_id'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function __construct(Teams $model)
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
    public function create(array $data) : Teams
    {
        if(!isset($data['structure_id'])){
            $structure_id = Auth::guard('api')->user()->logged_structure_id;
            if($structure_id==null){
                $structure_id = Auth::guard('api')->user()->structure_id;
            }
            $data['structure_id'] = $structure_id;
        }
        // Make sure it doesn't already exist
        if ($this->TeamsExists($data)) {
            throw new \Exception('A Team already exists with the name '.e($data['name']));
        }

        return DB::transaction(function () use ($data) {
            $Teams = $this->model::create($data);

            if ($Teams) {
                return $Teams;
            }

            throw new \Exception('An error occured attempting to create Teams');
        });
    }
    public function attach(array $data) : TeamUser
    {
        $rep_user = User::where('rep_id', $data['rep_id'])->first();
        if ($rep_user==null) {
            throw new \Exception('User Not Found');
        }
        $input_array = [
            'user_id' => $rep_user->id,
            'team_id' => $data['team_id']
        ];
        // Make sure it doesn't already exist
        if ($this->TeamUserExists($data, $rep_user->id)) {
            throw new \Exception('A Team already exists with the user '.e($rep_user['username']));
        }

        return DB::transaction(function () use ($input_array) {
            $Teams = TeamUser::create($input_array);

            if ($Teams) {
                return $Teams;
            }

            throw new \Exception('An error occured attempting to assign Teams');
        });
    }
    protected function TeamsExists($data) : bool
    {
        return $this->model
            ->where('name', strtolower($data['name']))
            ->where('structure_id', strtolower($data['structure_id']))
            ->count() > 0;
    }
    protected function TeamUserExists($data, $user_id) : bool
    {
        return TeamUser::
             where('user_id', $user_id)
            ->where('team_id', $data['team_id'])
            ->count() > 0;
    }
    public function find($id) : Teams
    {
        return $this->model->find($id);
    }
}

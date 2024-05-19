<?php

namespace App\Repositories\Backend;

use App\Models\UserTarget;
use App\Repositories\BaseRepository;
use Auth;
use DB;

/**
 * Class UserTargetRepository
 * @package App\Repositories\Backend
 * @version March 13, 2020, 10:06 am EAT
*/

class UserTargetRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'start_date',
        'end_date',
        'active',
        'create_by',
        'structure_id'
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

    public function __construct(UserTarget $model)
    {
        $this->model = $model;
    }

    /**
     * Configure the Model
     **/
    public function create(array $data) : UserTarget
    {
        $user_id = Auth::guard('api')->user()->id;
        // Make sure it doesn't already exist
        $input_array = $data;
        $input_array['start_date']  = \Carbon\Carbon::createFromTimeString($data['start_date'])->toDateString();
        $input_array['end_date']  = \Carbon\Carbon::createFromTimeString($data['end_date'])->toDateString();
        $input_array['create_by'] = $user_id;
        $input_array['active'] = true;
        unset($input_array['structures']);

        return DB::transaction(function () use ($input_array) {
            $UserTarget = $this->model::create($input_array);

            if ($UserTarget) {
                return $UserTarget;
            }

            throw new \Exception('An error occured attempting to create UserTarget');
        });
    }
    public function update(array $data, $id) : UserTarget
    {
        $input_array = $data;
        $input_array['start_date']  = \Carbon\Carbon::createFromTimeString($data['start_date'])->toDateString();
        $input_array['end_date']  = \Carbon\Carbon::createFromTimeString($data['end_date'])->toDateString();

        unset($input_array['structures']);

        return DB::transaction(function () use ($input_array, $id) {
            $UserTarget = $this->model::where('id', $id)->update($input_array);

            return UserTarget::where('id', $id)->first();

            abort(422, 'An error occured attempting to create UserTarget');
        });
    }
    protected function UserTargetExists($data, $structure_id) : bool
    {
        return $this->model
        ->where('user_id', strtolower($data['user_id']))
        ->where('structure_id', strtolower($structure_id))
        ->count() > 0;
    }
    public function find($id) : UserTarget
    {
            return $this->model->find($id);
    }
}

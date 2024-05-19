<?php

namespace App\Repositories\Backend;

use App\Models\Auth\User;
use App\Models\SalesRep;
use App\Repositories\BaseRepository;
use Auth;
use \Illuminate\Support\Facades\DB;

/**
 * Class SalesRepRepository
 * @package App\Repositories\Backend
 * @version October 21, 2019, 2:46 pm UTC
*/

class SalesRepRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'dist_id',
        'name',
        'description',
        'structure_id'
    ];

    public function __construct(SalesRep $model)
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
    public function create(array $data) : SalesRep
    {
        // Make sure it doesn't already exist
        return DB::transaction(function () use ($data) {

            $SalesRep = $this->model::create($data);
            if ($SalesRep) {
                return $SalesRep;
            }

        });
    }
    public function update(array $data, $id) : SalesRep
        {
            $user_id = Auth::guard('api')->user()->id;
            $user = User::where("id", $id)->first();

            $input_array = [
                'structure_id' => $data['structure_id']
            ];

            return DB::transaction(function () use ($input_array, $user, $data) {
                $user->update([
                    'structure_id' => $data['structure_id']
                ]);
                $SalesRep = SalesRep::whereId($user->rep_id)->first();
                if ($SalesRep) {
                    $SalesRep = tap($SalesRep)->update($input_array);
                    return $SalesRep;
                }
            });
        }
    protected function SalesRepExists($name) : bool
    {
        return $this->model
            ->where('name', strtolower($name))
            ->count() > 0;
    }
    public function find($id) : SalesRep
    {
        return $this->model->find($id);
    }
}

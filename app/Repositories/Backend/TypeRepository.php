<?php

namespace App\Repositories\Backend;

use App\Models\Type;
use Illuminate\Support\Facades\DB;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;

/**
 * Class TypeRepository
 * @package App\Repositories\Backend
 * @version February 13, 2020, 10:25 am UTC
*/

class TypeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'desc'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function __construct(Type $model)
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
    public function create(array $data) : Type
    {
        // Make sure it doesn't already exist
        if ($this->TypeExists($data)) {
            throw new \Exception('A Type already exists with the name '.e($data['name']));
        }
        $structure_id = Auth::guard('api')->user()->logged_structure_id;
        if($structure_id==null){
            $structure_id = Auth::guard('api')->user()->structure_id;
        }
        $data['structure_id'] = $structure_id;

        return DB::transaction(function () use ($data) {
            $Type = $this->model::create($data);

            if ($Type) {
                return $Type;
            }

            throw new \Exception('An error occured attempting to create Type');
        });
        }
    protected function TypeExists($data) : bool
    {
        return $this->model
        ->where('name', strtolower($data['name']))
        ->where('structure_id', strtolower($data['structure_id']))
        ->count() > 0;
    }
    public function find($id) : Type
    {
            return $this->model->find($id);
    }
}

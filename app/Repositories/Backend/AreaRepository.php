<?php

namespace App\Repositories\Backend;

use App\Models\Area;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Class AreaRepository
 * @package App\Repositories\Backend
 * @version April 22, 2021, 8:54 pm UTC
*/

class AreaRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'region_id',
        'name',
        'desc',
        'structure_id'
    ];

    public function __construct(Area $model)
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
    public function create(array $data) : Area
    {
        $structure_id = Auth::guard('api')->user()->logged_structure_id;
        if($structure_id==null){
            $structure_id = Auth::guard('api')->user()->structure_id;
        }
        $data['structure_id'] = $structure_id;
        // Make sure it doesn't already exist
        if ($this->AreaExists($data)) {
            throw new \Exception('An Area already exists with the name '.e($data['name']));
        }

        return DB::transaction(function () use ($data) {
            $Area = $this->model::create($data);

            if ($Area) {
                return $Area;
            }

            throw new \Exception('An error occured attempting to create Area');
        });
        }
    public function update( array $data, $id)
    {
        // Make sure it doesn't already exist
        unset($data["structures"]);
        return DB::transaction(function () use ($id, $data) {
            try{
            $Area = $this->find($id);
            if ($Area) {
                $Area::where('id', $id)
                ->update($data);
                return $this->find($id);
            }
            }catch(Exception $e){
                abort(422, 'An error occured attempting to update Area');
            }

        });
    }
    protected function AreaExists($data) : bool
    {
        return $this->model
            ->where('name', strtolower($data['name']))
            ->where('structure_id', strtolower($data['structure_id']))
            ->count() > 0;
    }
    public function find($id) : Area
    {
        return $this->model->find($id);
    }
}

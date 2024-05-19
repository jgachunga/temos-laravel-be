<?php

namespace App\Repositories\Backend;

use App\Models\Region;
use App\Repositories\BaseRepository;
use Auth;
use DB;

/**
 * Class RegionRepository
 * @package App\Repositories\Backend
 * @version March 6, 2020, 10:03 am EAT
*/

class RegionRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'Region_id',
        'name',
        'desc'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function __construct(Region $model)
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
    public function create(array $data) : Region
    {
        $structure_id = Auth::guard('api')->user()->logged_structure_id;
        if($structure_id==null){
            $structure_id = Auth::guard('api')->user()->structure_id;
        }
        // $data['structure_id'] = $structure_id;
        // Make sure it doesn't already exist
        if ($this->RegionExists($data)) {
            throw new \Exception('A Region already exists with the name '.e($data['name']));
        }

        return DB::transaction(function () use ($data) {
            $Region = $this->model::create($data);

            if ($Region) {
                return $Region;
            }

            throw new \Exception('An error occured attempting to create Region');
        });
    }
    public function update( array $data, $id)
    {
        // Make sure it doesn't already exist
        unset($data["structures"]);
        return DB::transaction(function () use ($id, $data) {
            try{
                $this->model::where('id', $id)
                ->update($data);
                return $this->find($id);
            }catch(Exception $e){
                abort(422, 'An error occured attempting to update Region');
            }

        });
    }
    protected function RegionExists($data) : bool
    {
        return $this->model
            ->where('name', strtolower($data['name']))
            ->count() > 0;
    }
    public function find($id) : Region
    {
        return $this->model->find($id);
    }
}

<?php

namespace App\Repositories\Backend;

use App\Models\Stockist;
use App\Repositories\BaseRepository;
use Auth;
use DB;

/**
 * Class StockistRepository
 * @package App\Repositories\Backend
 * @version March 6, 2020, 10:04 am EAT
*/

class StockistRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'town_id',
        'route_id',
        'name',
        'desc'
    ];

    public function __construct(Stockist $model)
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
    public function create(array $data) : Stockist
    {
        $structure_id = Auth::guard('api')->user()->logged_structure_id;
        if($structure_id==null){
            $structure_id = Auth::guard('api')->user()->structure_id;
        }
        // $data['structure_id'] = $structure_id;
        // Make sure it doesn't already exist
        if ($this->StockistExists($data)) {
            throw new \Exception('A Stockist already exists with the name '.e($data['name']));
        }

        return DB::transaction(function () use ($data) {
            $Stockist = $this->model::create($data);

            if ($Stockist) {
                return $Stockist;
            }

            abort(422, 'An error occured attempting to create Stockist');
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
                abort(422, 'An error occured attempting to update Stockist');
            }

        });
    }
    protected function StockistExists($data) : bool
    {
        return $this->model
            ->where('name', strtolower($data['name']))
            ->count() > 0;
    }
    public function getbyRouteId($route_id)
    {
        $stockists = $this->model::where('route_id', $route_id)->get();
        return $stockists;
    }

    public function find($id) : Stockist
    {
        return $this->model->find($id);
    }
}

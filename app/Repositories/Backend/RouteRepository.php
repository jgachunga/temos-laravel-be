<?php

namespace App\Repositories\Backend;

use App\Models\Route;
use App\Models\UserRoute;
use App\Repositories\BaseRepository;
use Auth;
use DB;

/**
 * Class RouteRepository
 * @package App\Repositories\Backend
 * @version March 6, 2020, 10:03 am EAT
*/

class RouteRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'region_id',
        'name',
        'desc'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function __construct(Route $model)
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
    public function create(array $data) : Route
    {
        $structure_id = Auth::guard('api')->user()->logged_structure_id;
        if($structure_id==null){
            $structure_id = Auth::guard('api')->user()->structure_id;
        }
        // $data['structure_id'] = $structure_id;
        // Make sure it doesn't already exist
        if ($this->RouteExists($data)) {
            throw new \Exception('A Route already exists with the name '.e($data['name']));
        }

        return DB::transaction(function () use ($data) {
            $Route = $this->model::create($data);

            if ($Route) {
                return $Route;
            }

            throw new \Exception('An error occured attempting to create Route');
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
                abort(422, 'An error occured attempting to update Country');
            }

        });
    }
    protected function RouteExists($data) : bool
    {
        return $this->model
            ->where('name', strtolower($data['name']))
            ->count() > 0;
    }
    public function getbyUserId($user_id)
    {
        $user_routes = UserRoute::where('user_id', $user_id)
        ->with('route', 'user')
        ->get();
        return $user_routes;
    }
    public function find($id) : Route
    {
        return $this->model->find($id);
    }
}

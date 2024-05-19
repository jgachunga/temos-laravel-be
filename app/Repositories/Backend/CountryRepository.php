<?php

namespace App\Repositories\Backend;

use App\Models\Country;
use App\Repositories\BaseRepository;
use Auth;
use DB;

/**
 * Class CountryRepository
 * @package App\Repositories\Backend
 * @version March 6, 2020, 10:02 am EAT
*/

class CountryRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'desc'
    ];

    public function __construct(Country $model)
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
    public function create(array $data)
    {
        // Make sure it doesn't already exist
        if ($this->CountryExists($data)) {
            abort(422, "A Country already exists with the name ".e($data['name']));
        }

        return DB::transaction(function () use ($data) {
            $Country = $this->model::create($data);

            if ($Country) {
                return $Country;
            }

            throw new \Exception('An error occured attempting to create Country');
        });
    }
    public function update( array $data, $id)
    {
        // Make sure it doesn't already exist
        unset($data["structures"]);
        return DB::transaction(function () use ($id, $data) {
            try{
            $Country = $this->find($id);
                if ($Country) {
                    $Country::where('id', $id)
                    ->update($data);
                    return $this->find($id);
                }
            }catch(Exception $e){
                abort(422, 'An error occured attempting to update Country');
            }

        });
    }
    protected function CountryExists($data) : bool
    {
        return $this->model
            ->where('name', strtolower($data['name']))
            ->count() > 0;
    }
    public function find($id) : Country
    {
        return $this->model->find($id);
    }
}

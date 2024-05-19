<?php

namespace App\Repositories\Backend;

use App\Models\Auth\User;
use \Illuminate\Support\Facades\DB;
use App\Repositories\BaseRepository;
use App\Models\SaleStructure;

/**
 * Class UserRepository
 * @package App\Repositories\Backend
 * @version September 22, 2019, 7:49 am UTC
*/

class UserRepository extends BaseRepository
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
    public function __construct(User $model)
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
    public function create(array $data) : User
    {
        // Make sure it doesn't already exist
        if ($this->UserExists($data['name'])) {
            throw new \Exception('A User already exists with the name '.e($data['name']));
        }

        return DB::transaction(function () use ($data) {
            $User = $this->model::create($data);

            if ($User) {
                return $User;
            }

            throw new \Exception('An error occured attempting to create User');
        });
    }
    public function update(array $data, $id) : User
    {
        return DB::transaction(function () use ($data, $id) {
            $saleStructure = User::whereId($id)->update($data);
            if ($saleStructure) {
                $saleStructure = User::whereId($id)->first();
                return $saleStructure;
            }

            throw new \Exception('An error occured attempting to update SaleStructure');
        });
    }
    public function list($structure_id){
        $root_categories = SaleStructure::where('parent_id', '=' , $structure_id)->get()->toArray();
        $array_categories = $this->list_categories($root_categories);
        return $array_categories;
    }
    public function list_categories(Array $categories)
    {
    $data = [];

    foreach($categories as $category)
    {
        $childrenarr = SaleStructure::where('parent_id', '=' , $category['id'])->get()->toArray();
        $dataarr[] = $category['id'];
        if($childrenarr!=[]){
            $this->list_categories($childrenarr);
        }

    }

    return $dataarr;
    }

    protected function UserExists($name) : bool
    {
        return $this->model
            ->where('name', strtolower($name))
            ->count() > 0;
    }
    public function find($id) : User
    {
        return $this->model->find($id);
    }
}

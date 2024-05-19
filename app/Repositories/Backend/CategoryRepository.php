<?php

namespace App\Repositories\Backend;

use App\Models\Category;
use \Illuminate\Support\Facades\DB;
use App\Repositories\BaseRepository;

/**
 * Class CategoryRepository
 * @package App\Repositories\Backend
 * @version September 22, 2019, 7:49 am UTC
*/

class CategoryRepository extends BaseRepository
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
    public function __construct(Category $model)
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
    public function create(array $data) : Category
    {
        // Make sure it doesn't already exist
        unset($data['structures']);
        if ($this->CategoryExists($data['name'])) {
            throw new GeneralException('A Category already exists with the name '.e($data['name']));
        }

        return DB::transaction(function () use ($data) {
            $Category = $this->model::create($data);

            if ($Category) {
                return $Category;
            }

            throw new GeneralException('An error occured attempting to create Category');
        });
    }
    public function update(array $data, $id) : Channel
    {
        unset($data['structures']);
        return DB::transaction(function () use ($data, $id) {
            $Category = Category::whereId($id)->update($data);
            if ($Category) {
                $Category = Category::whereId($id)->first();
                return $Category;
            }

            abort(422, 'An error occured attempting to update Category');
        });
    }
    protected function CategoryExists($name) : bool
    {
        return $this->model
            ->where('name', strtolower($name))
            ->count() > 0;
    }
    public function find($id) : Category
    {
        return $this->model->find($id);
    }
}

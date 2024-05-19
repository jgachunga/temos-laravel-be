<?php

namespace App\Repositories\Backend;

use App\Models\SaleStructure;
use App\Repositories\BaseRepository;
use Illuminate\Support\Collection;
use \Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

/**
 * Class SaleStructureRepository
 * @package App\Repositories\Backend
 * @version October 12, 2019, 9:29 am UTC
*/

class SaleStructureRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title',
        'parent_id'
    ];

    public function __construct(SaleStructure $model)
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

    public function create(array $data) : SaleStructure
    {
        // Make sure it doesn't already exist
        if ($this->SaleStructureExists($data['title'])) {
            throw new \Exception('A SaleStructure already exists with the name '.e($data['title']));
        }

        return DB::transaction(function () use ($data) {
            $SaleStructure = $this->model::create($data);

            if ($SaleStructure) {
                return $SaleStructure;
            }

            throw new \Exception('An error occured attempting to create SaleStructure');
        });
        }
        protected function SaleStructureExists($name) : bool
        {
            return $this->model
                ->where('title', strtolower($name))
                ->count() > 0;
        }
        public function update(array $data, $id) : SaleStructure
        {
            return DB::transaction(function () use ($data, $id) {
                $saleStructure = SaleStructure::whereId($id)->update(
                    [
                        'title' => $data['title']
                    ]
                );
                if ($saleStructure) {
                    $saleStructure = SaleStructure::whereId($id)->first();
                    return $saleStructure;
                }

                throw new \Exception('An error occured attempting to update SaleStructure');
            });
        }
        public function list(){
            $structure_id = Auth::guard('api')->user()->logged_structure_id;
            if($structure_id==null){
                $structure_id = Auth::guard('api')->user()->structure_id;
            }
            $root_categories = SaleStructure::where('id', '=' , $structure_id)->get()->toArray();
            $array_categories = $this->list_categories($root_categories);
            return $array_categories;
        }
        public function list_categories(Array $categories)
        {
        $data = [];

        foreach($categories as $category)
        {
            $childrenarr = SaleStructure::where('parent_id', '=' , $category['id'])->get()->toArray();
            $data[] = [
            'cat_id' => $category['id'],
            'name' => $category['title'],
            'children' => $childrenarr!=[] ? $this->list_categories($childrenarr) : [],
            ];
        }

        return $data;
        }
        public function find($id)
        {
            return $this->model->find($id);
        }
}

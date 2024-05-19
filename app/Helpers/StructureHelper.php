<?php

namespace App\Helpers;
use Illuminate\Support\Arr;
use App\Models\SaleStructure;

/**
 * Class Socialite.
 */
class StructureHelper
{
    /**
     * List of the accepted third party provider types to login with.
     *
     * @return array
     */
    public function getChildren($structure_id)
    {
        $root_categories = SaleStructure::where('parent_id', '=' , $structure_id)->get()->toArray();
        $array_categories = $this->list_categories($root_categories);
        $array_categories = Arr::flatten($array_categories);
        array_push($array_categories, (int)$structure_id);
        return $array_categories;
    }
    public function list_categories(Array $categories)
    {
        $data = [];

        foreach($categories as $category)
        {
            $childrenarr = SaleStructure::where('parent_id', '=' , $category['id'])->get()->toArray();
            $data[] = $category['id'];
            if($childrenarr!=[]){
                $data[] = $this->list_categories($childrenarr);
            }
        }

        return $data;
    }
}

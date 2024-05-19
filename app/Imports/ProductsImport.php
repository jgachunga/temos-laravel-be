<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use App\Models\Category;
use App\Exceptions\GeneralException;

class ProductsImport implements WithBatchInserts, ToModel, WithHeadingRow, WithCalculatedFormulas
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function  __construct()
    {
    }

    public function model(array $row)
    {
        $structure_id = 3;
        $cat_id = null;
        if(isset($row['category'])&&!is_null($row['category'])){
            $cat_id = Category::where('name', $row['category'])->pluck('id')->first();
        }else{
            throw new \Exception('Category for product '.$row['name'].' cannot be empty');
        }
        if($cat_id == null){
            throw new \Exception('Category for product '.$row['name'].' not found in the database');
        }
        return new Product([
            'name' => $row['name'],
            'code' => isset($row['code']) ? $row['code'] : null,
            'cat_id' => $cat_id,
            'desc' => isset($row['description']) ? $row['description'] : null,
            'price' => isset($row['unit_price']) ? $row['unit_price'] : null,
            'has_multiple_prices' => false,
            'discount' => isset($row['discount']) ? $row['discount'] : null,
            'ex_factory_price' => isset($row['ex_factory']) ? $row['ex_factory'] : null,
            'retail_price_recommended' => isset($row['retail_price']) ? $row['retail_price'] : null,
            'carton_pieces' => isset($row['pack_pieces']) ? $row['pack_pieces'] : null,
            'carton_price' => isset($row['pack_price']) ? $row['pack_price'] : null,
            'pre_tax_carton_price' => isset($row['pre_tax_carton_price']) ? $row['pre_tax_carton_price'] : null,
            'pre_tax_price' => isset($row['pre_tax_price']) ? $row['pre_tax_price'] : null,
            'taxable' => isset($row['taxable']) ? $row['taxable'] : null,
            'vat_applicable' => isset($row['vat_applicable']) ? $row['vat_applicable'] : null,
            'structure_id' => $structure_id
        ]);
    }
    public function batchSize(): int
    {
        return 1000;
    }
}

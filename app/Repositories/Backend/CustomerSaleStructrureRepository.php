<?php

namespace App\Repositories\Backend;

use App\Models\CustomerSaleStructrure;
use App\Repositories\BaseRepository;

/**
 * Class CustomerSaleStructrureRepository
 * @package App\Repositories\Backend
 * @version October 26, 2019, 6:23 pm UTC
*/

class CustomerSaleStructrureRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'cust_id',
        'structure_id'
    ];

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
    public function model()
    {
        return CustomerSaleStructrure::class;
    }
}

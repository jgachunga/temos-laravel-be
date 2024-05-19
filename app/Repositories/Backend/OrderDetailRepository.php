<?php

namespace App\Repositories\Backend;

use App\Models\OrderDetail;
use App\Repositories\BaseRepository;

/**
 * Class OrderDetailRepository
 * @package App\Repositories\Backend
 * @version October 28, 2019, 9:53 am UTC
*/

class OrderDetailRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'order_id',
        'product_code',
        'quantity',
        'sku',
        'price',
        'price_from',
        'total'
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
        return OrderDetail::class;
    }
}

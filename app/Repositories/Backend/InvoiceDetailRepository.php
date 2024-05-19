<?php

namespace App\Repositories\Backend;

use App\Models\InvoiceDetail;
use App\Repositories\BaseRepository;

/**
 * Class InvoiceDetailRepository
 * @package App\Repositories\Backend
 * @version March 6, 2020, 10:32 am EAT
*/

class InvoiceDetailRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'invoice_id',
        'product_id',
        'product_code',
        'price',
        'quantity',
        'taxes',
        'total_amount'
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
        return InvoiceDetail::class;
    }
}

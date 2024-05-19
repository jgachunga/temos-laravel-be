<?php

namespace App\Repositories\Backend;

use App\Models\Uom;
use App\Repositories\BaseRepository;

/**
 * Class UomRepository
 * @package App\Repositories\Backend
 * @version March 16, 2020, 1:42 am EAT
*/

class UomRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'carton_pieces',
        'carton_price'
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
        return Uom::class;
    }
}

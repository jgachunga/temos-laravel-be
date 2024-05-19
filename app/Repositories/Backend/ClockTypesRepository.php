<?php

namespace App\Repositories\Backend;

use App\Models\ClockTypes;
use App\Repositories\BaseRepository;

/**
 * Class ClockTypesRepository
 * @package App\Repositories\Backend
 * @version February 24, 2020, 3:29 pm EAT
*/

class ClockTypesRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name'
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
        return ClockTypes::class;
    }
}

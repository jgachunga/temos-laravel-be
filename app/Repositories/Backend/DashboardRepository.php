<?php

namespace App\Repositories\Backend;

use App\Models\CurrentStatuses;
use App\Repositories\BaseRepository;

/**
 * Class CurrentStatusesRepository
 * @package App\Repositories\Backend
 * @version February 23, 2020, 7:18 pm EAT
*/

class DashboardRepository extends BaseRepository
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
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return CurrentStatuses::class;
    }
}

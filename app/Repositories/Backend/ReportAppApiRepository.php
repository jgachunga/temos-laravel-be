<?php

namespace App\Repositories\Backend;

use App\Models\ReportAppApi;
use App\Repositories\BaseRepository;

/**
 * Class ReportAppApiRepository
 * @package App\Repositories\Backend
 * @version January 31, 2023, 1:26 am UTC
*/

class ReportAppApiRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        
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
        return ReportAppApi::class;
    }
}

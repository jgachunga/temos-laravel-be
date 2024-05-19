<?php

namespace App\Repositories\Backend;

use App\Models\FormStatus;
use App\Repositories\BaseRepository;

/**
 * Class FormStatusRepository
 * @package App\Repositories\Backend
 * @version February 19, 2020, 2:11 pm UTC
*/

class FormStatusRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'status',
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
        return FormStatus::class;
    }
}

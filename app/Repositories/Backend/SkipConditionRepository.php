<?php

namespace App\Repositories\Backend;

use App\Models\SkipCondition;
use App\Repositories\BaseRepository;

/**
 * Class SkipConditionRepository
 * @package App\Repositories\Backend
 * @version July 24, 2021, 8:54 pm EAT
*/

class SkipConditionRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'question_id',
        'label',
        'value'
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
        return SkipCondition::class;
    }
}

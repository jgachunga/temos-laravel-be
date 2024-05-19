<?php

namespace App\Repositories\Backend;

use App\Models\UserLocationHistory;
use App\Repositories\BaseRepository;

/**
 * Class UserLocationHistoryRepository
 * @package App\Repositories\Backend
 * @version February 23, 2020, 7:20 pm EAT
*/

class UserLocationHistoryRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'form_id',
        'customer_id',
        'current_status_id',
        'timestamp',
        'lat',
        'long',
        'accuracy',
        'mocked',
        'geotimestamp'
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
        return UserLocationHistory::class;
    }
}

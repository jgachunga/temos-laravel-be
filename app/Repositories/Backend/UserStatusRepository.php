<?php

namespace App\Repositories\Backend;

use App\Models\UserStatus;
use App\Repositories\BaseRepository;

/**
 * Class UserStatusRepository
 * @package App\Repositories\Backend
 * @version February 23, 2020, 7:19 pm EAT
*/

class UserStatusRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'form_id',
        'customer_id',
        'current_status_id',
        'last_seen',
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
        return UserStatus::class;
    }
}

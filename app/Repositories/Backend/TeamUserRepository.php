<?php

namespace App\Repositories\Backend;

use App\Models\TeamUser;
use App\Repositories\BaseRepository;

/**
 * Class TeamUserRepository
 * @package App\Repositories\Backend
 * @version March 12, 2020, 11:33 am EAT
*/

class TeamUserRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'team_id',
        'user_id',
        'active'
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
        return TeamUser::class;
    }
}

<?php

namespace App\Repositories\Backend;

use App\Models\UserRoute;
use App\Repositories\BaseRepository;

/**
 * Class UserRouteRepository
 * @package App\Repositories\Backend
 * @version April 25, 2021, 7:49 pm UTC
*/

class UserRouteRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'route_id',
        'user_id'
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
        return UserRoute::class;
    }
}

<?php

namespace App\Repositories\Backend;

use App\Models\Version;
use App\Repositories\BaseRepository;

/**
 * Class VersionRepository
 * @package App\Repositories\Backend
 * @version February 18, 2020, 6:47 pm UTC
*/

class VersionRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'code',
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
        return Version::class;
    }
}

<?php

namespace App\Repositories\Backend;

use App\Models\Sync;
use App\Repositories\BaseRepository;

/**
 * Class SyncRepository
 * @package App\Repositories\Backend
 * @version January 16, 2023, 11:45 pm UTC
*/

class SyncRepository extends BaseRepository
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
        return Sync::class;
    }
}

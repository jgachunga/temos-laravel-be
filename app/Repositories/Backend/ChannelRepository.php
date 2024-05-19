<?php

namespace App\Repositories\Backend;

use App\Models\Channel;
use \Illuminate\Support\Facades\DB;
use App\Repositories\BaseRepository;
use App\Models\SaleStructure;
use Illuminate\Support\Facades\Auth;

/**
 * Class ChannelRepository
 * @package App\Repositories\Backend
 * @version September 22, 2019, 7:49 am UTC
*/

class ChannelRepository extends BaseRepository
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
    public function __construct(Channel $model)
    {
        $this->model = $model;
    }
    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }
    public function create(array $data) : Channel
    {
        // Make sure it doesn't already exist

        unset($data['structures']);

        if ($this->ChannelExists($data)) {
           abort(422, 'A Channel already exists with the name '.e($data['name']));
        }

        return DB::transaction(function () use ($data) {
            $Channel = $this->model::create($data);

            if ($Channel) {
                return $Channel;
            }

            abort(422, 'An error occured attempting to create Channel');
        });
    }
    public function update(array $data, $id) : Channel
    {
        unset($data['structures']);
        return DB::transaction(function () use ($data, $id) {
            $Channel = Channel::whereId($id)->update($data);
            if ($Channel) {
                $Channel = Channel::whereId($id)->first();
                return $Channel;
            }

            abort(422, 'An error occured attempting to update SaleStructure');
        });
    }

    protected function ChannelExists($data) : bool
    {
        return $this->model
            ->where('name', strtolower($data['name']))
            ->where('structure_id', strtolower($data['structure_id']))
            ->count() > 0;
    }
    public function find($id) : Channel
    {
        return $this->model->find($id);
    }
}

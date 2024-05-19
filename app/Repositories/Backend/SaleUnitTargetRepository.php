<?php

namespace App\Repositories\Backend;

use App\Models\SaleUnitTarget;
use App\Repositories\BaseRepository;
use Auth;
use DB;

/**
 * Class SaleUnitTargetRepository
 * @package App\Repositories\Backend
 * @version March 13, 2020, 10:06 am EAT
*/

class SaleUnitTargetRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'structure_id',
        'start_date',
        'end_date',
        'active',
        'create_by'
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


    public function __construct(SaleUnitTarget $model)
    {
        $this->model = $model;
    }

    /**
     * Configure the Model
     **/
    public function create(array $data) : SaleUnitTarget
    {
        $user_id = Auth::guard('api')->user()->id;
        $structure_id = Auth::guard('api')->user()->logged_structure_id;
        if($structure_id==null){
            $structure_id = Auth::guard('api')->user()->structure_id;
        }
        // Make sure it doesn't already exist
        if ($this->SaleUnitTargetExists($data)) {
            throw new \Exception('A SaleUnitTarget already exists for the user '.e($data['user_id']));
        }
        $input_array['structure_id'] = $data['structure_id'];
        $input_array['start_date']  = \Carbon\Carbon::createFromTimeString($data['start_date'])->toDateString();
        $input_array['end_date']  = \Carbon\Carbon::createFromTimeString($data['end_date'])->toDateString();
        $input_array['create_by'] = $user_id;
        $input_array['target'] = $data['target'];
        $input_array['active'] = true;

        return DB::transaction(function () use ($input_array) {
            $SaleUnitTarget = $this->model::create($input_array);

            if ($SaleUnitTarget) {
                return $SaleUnitTarget;
            }

            throw new \Exception('An error occured attempting to create SaleUnitTarget');
        });
        }
    protected function SaleUnitTargetExists($data) : bool
    {
        return $this->model
        ->where('structure_id', strtolower($data['structure_id']))
        ->count() > 0;
    }
    public function find($id) : SaleUnitTarget
    {
            return $this->model->find($id);
    }
}

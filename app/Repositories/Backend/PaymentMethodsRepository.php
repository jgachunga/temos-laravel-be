<?php

namespace App\Repositories\Backend;

use App\Exceptions\GeneralException;
use App\Models\PaymentMethods;
use App\Repositories\BaseRepository;
use DB;

/**
 * Class PaymentMethodsRepository
 * @package App\Repositories\Backend
 * @version October 26, 2019, 3:44 am UTC
*/

class PaymentMethodsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'img_url'
    ];

    public function __construct(PaymentMethods $model)
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

    /**
     * Configure the Model
     **/
    public function create(array $data) : PaymentMethods
    {
        // Make sure it doesn't already exist
        if ($this->PaymentMethodsExists($data['name'])) {
            throw new GeneralException('A PaymentMethods already exists with the name '.e($data['name']));
        }

        return DB::transaction(function () use ($data) {
            $PaymentMethods = $this->model::create($data);

            if ($PaymentMethods) {
                return $PaymentMethods;
            }

            throw new GeneralException('An error occured attempting to create PaymentMethods');
        });
        }
        protected function PaymentMethodsExists($name) : bool
        {
            return $this->model
                ->where('name', strtolower($name))
                ->count() > 0;
        }
        public function find($id) : PaymentMethods
        {
            return $this->model->find($id);
        }
}

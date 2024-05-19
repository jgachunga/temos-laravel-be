<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\API\V1\CreateUomAPIRequest;
use App\Http\Requests\API\V1\UpdateUomAPIRequest;
use App\Models\Uom;
use App\Repositories\Backend\UomRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class UomController
 * @package App\Http\Controllers\API\V1
 */

class UomAPIController extends AppBaseController
{
    /** @var  UomRepository */
    private $uomRepository;

    public function __construct(UomRepository $uomRepo)
    {
        $this->uomRepository = $uomRepo;
    }

    /**
     * Display a listing of the Uom.
     * GET|HEAD /uoms
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $uoms = $this->uomRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($uoms->toArray(), 'Uoms retrieved successfully');
    }

    /**
     * Store a newly created Uom in storage.
     * POST /uoms
     *
     * @param CreateUomAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateUomAPIRequest $request)
    {
        $input = $request->all();

        $uom = $this->uomRepository->create($input);

        return $this->sendResponse($uom->toArray(), 'Uom saved successfully');
    }

    /**
     * Display the specified Uom.
     * GET|HEAD /uoms/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Uom $uom */
        $uom = $this->uomRepository->find($id);

        if (empty($uom)) {
            return $this->sendError('Uom not found');
        }

        return $this->sendResponse($uom->toArray(), 'Uom retrieved successfully');
    }

    /**
     * Update the specified Uom in storage.
     * PUT/PATCH /uoms/{id}
     *
     * @param int $id
     * @param UpdateUomAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUomAPIRequest $request)
    {
        $input = $request->all();

        /** @var Uom $uom */
        $uom = $this->uomRepository->find($id);

        if (empty($uom)) {
            return $this->sendError('Uom not found');
        }

        $uom = $this->uomRepository->update($input, $id);

        return $this->sendResponse($uom->toArray(), 'Uom updated successfully');
    }

    /**
     * Remove the specified Uom from storage.
     * DELETE /uoms/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Uom $uom */
        $uom = $this->uomRepository->find($id);

        if (empty($uom)) {
            return $this->sendError('Uom not found');
        }

        $uom->delete();

        return $this->sendResponse($id, 'Uom deleted successfully');
    }
}

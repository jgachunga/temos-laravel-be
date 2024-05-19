<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\API\V1\CreateTypeAPIRequest;
use App\Http\Requests\API\V1\UpdateTypeAPIRequest;
use App\Models\Type;
use App\Repositories\Backend\TypeRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;
use Illuminate\Support\Facades\Auth;

/**
 * Class TypeController
 * @package App\Http\Controllers\API\V1
 */

class TypeAPIController extends AppBaseController
{
    /** @var  TypeRepository */
    private $typeRepository;

    public function __construct(TypeRepository $typeRepo)
    {
        $this->typeRepository = $typeRepo;
    }

    /**
     * Display a listing of the Type.
     * GET|HEAD /types
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $structures = $request->get('structures');
        $types = Type::whereIn('structure_id', $structures)->orderByDesc('created_at')->paginate(5);

        return $this->sendResponse($types, 'Types retrieved successfully');
    }

    public function all(Request $request)
    {
        $structures = $request->get('structures');
        $types = $this->typeRepository->whereIn('structure_id', $structures)->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($types->toArray(), 'Types retrieved successfully');
    }

    /**
     * Store a newly created Type in storage.
     * POST /types
     *
     * @param CreateTypeAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateTypeAPIRequest $request)
    {
        $input = $request->all();

        $type = $this->typeRepository->create($input);

        return $this->sendResponse($type->toArray(), 'Type saved successfully');
    }

    /**
     * Display the specified Type.
     * GET|HEAD /types/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Type $type */
        $type = $this->typeRepository->find($id);

        if (empty($type)) {
            return $this->sendError('Type not found');
        }

        return $this->sendResponse($type->toArray(), 'Type retrieved successfully');
    }

    /**
     * Update the specified Type in storage.
     * PUT/PATCH /types/{id}
     *
     * @param int $id
     * @param UpdateTypeAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTypeAPIRequest $request)
    {
        $input = $request->all();

        /** @var Type $type */
        $type = $this->typeRepository->find($id);

        if (empty($type)) {
            return $this->sendError('Type not found');
        }

        $type = $this->typeRepository->update($input, $id);

        return $this->sendResponse($type->toArray(), 'Type updated successfully');
    }

    /**
     * Remove the specified Type from storage.
     * DELETE /types/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Type $type */
        $type = $this->typeRepository->find($id);

        if (empty($type)) {
            return $this->sendError('Type not found');
        }

        $type->delete();

        return $this->sendResponse($id, 'Type deleted successfully');
    }
}

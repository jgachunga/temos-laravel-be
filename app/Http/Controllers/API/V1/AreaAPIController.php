<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\API\V1\CreateAreaAPIRequest;
use App\Http\Requests\API\V1\UpdateAreaAPIRequest;
use App\Models\Area;
use App\Repositories\Backend\AreaRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class AreaController
 * @package App\Http\Controllers\API\V1
 */

class AreaAPIController extends AppBaseController
{
    /** @var  AreaRepository */
    private $areaRepository;

    public function __construct(AreaRepository $areaRepo)
    {
        $this->areaRepository = $areaRepo;
    }

    /**
     * Display a listing of the Area.
     * GET|HEAD /areas
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $page = $request->only('page');
        if(isset($page)&&!empty($page)){
            $areas = Area::with('region')->orderByDesc('created_at')->paginate(5);
        }else{
            $areas = $this->areaRepository->with('region')->all(
                $request->except(['skip', 'limit']),
                $request->get('skip'),
                $request->get('limit')
            );
        }

        return $this->sendResponse($areas->toArray(), 'Areas retrieved successfully');
    }

    /**
     * Store a newly created Area in storage.
     * POST /areas
     *
     * @param CreateAreaAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateAreaAPIRequest $request)
    {
        $input = $request->all();

        $area = $this->areaRepository->create($input);

        return $this->sendResponse($area->toArray(), 'Area saved successfully');
    }

    /**
     * Display the specified Area.
     * GET|HEAD /areas/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Area $area */
        $area = $this->areaRepository->find($id);

        if (empty($area)) {
            return $this->sendError('Area not found');
        }

        return $this->sendResponse($area->toArray(), 'Area retrieved successfully');
    }

    /**
     * Update the specified Area in storage.
     * PUT/PATCH /areas/{id}
     *
     * @param int $id
     * @param UpdateAreaAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAreaAPIRequest $request)
    {
        $input = $request->all();

        /** @var Area $area */
        $area = $this->areaRepository->find($id);

        if (empty($area)) {
            return $this->sendError('Area not found');
        }

        $area = $this->areaRepository->update($input, $id);

        return $this->sendResponse($area->toArray(), 'Area updated successfully');
    }

    /**
     * Remove the specified Area from storage.
     * DELETE /areas/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Area $area */
        $area = $this->areaRepository->find($id);

        if (empty($area)) {
            return $this->sendError('Area not found');
        }

        $area->delete();

        return $this->sendSuccess('Area deleted successfully');
    }
}

<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\API\V1\CreateTownAPIRequest;
use App\Http\Requests\API\V1\UpdateTownAPIRequest;
use App\Models\Town;
use App\Repositories\Backend\TownRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class TownController
 * @package App\Http\Controllers\API\V1
 */

class TownAPIController extends AppBaseController
{
    /** @var  TownRepository */
    private $townRepository;

    public function __construct(TownRepository $townRepo)
    {
        $this->townRepository = $townRepo;
    }

    /**
     * Display a listing of the Town.
     * GET|HEAD /towns
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $page = $request->only('page');
        if(isset($page)&&!empty($page)){
            $towns = Town::with('route')->orderByDesc('created_at')->paginate(5);
        }else{
            $towns = $this->townRepository->with('route')->all(
                $request->except(['skip', 'limit']),
                $request->get('skip'),
                $request->get('limit')
            );
        }

        return $this->sendResponse($towns, 'Towns retrieved successfully');
    }

    /**
     * Store a newly created Town in storage.
     * POST /towns
     *
     * @param CreateTownAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateTownAPIRequest $request)
    {
        $input = $request->all();

        $town = $this->townRepository->create($input);

        return $this->sendResponse($town->toArray(), 'Town saved successfully');
    }

    /**
     * Display the specified Town.
     * GET|HEAD /towns/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Town $town */
        $town = $this->townRepository->find($id);

        if (empty($town)) {
            return $this->sendError('Town not found');
        }

        return $this->sendResponse($town->toArray(), 'Town retrieved successfully');
    }

    /**
     * Update the specified Town in storage.
     * PUT/PATCH /towns/{id}
     *
     * @param int $id
     * @param UpdateTownAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTownAPIRequest $request)
    {
        $input = $request->all();

        /** @var Town $town */
        $town = $this->townRepository->find($id);

        if (empty($town)) {
            return $this->sendError('Town not found');
        }

        $town = $this->townRepository->update($input, $id);

        return $this->sendResponse($town->toArray(), 'Town updated successfully');
    }

    /**
     * Remove the specified Town from storage.
     * DELETE /towns/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Town $town */
        $town = $this->townRepository->find($id);

        if (empty($town)) {
            return $this->sendError('Town not found');
        }

        $town->delete();

        return $this->sendResponse($id, 'Town deleted successfully');
    }
}

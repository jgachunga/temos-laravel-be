<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\API\V1\CreateUserRouteAPIRequest;
use App\Http\Requests\API\V1\UpdateUserRouteAPIRequest;
use App\Models\UserRoute;
use App\Repositories\Backend\UserRouteRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class UserRouteController
 * @package App\Http\Controllers\API\V1
 */

class UserRouteAPIController extends AppBaseController
{
    /** @var  UserRouteRepository */
    private $userRouteRepository;

    public function __construct(UserRouteRepository $userRouteRepo)
    {
        $this->userRouteRepository = $userRouteRepo;
    }

    /**
     * Display a listing of the UserRoute.
     * GET|HEAD /userRoutes
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $userRoutes = $this->userRouteRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($userRoutes->toArray(), 'User Routes retrieved successfully');
    }

    /**
     * Store a newly created UserRoute in storage.
     * POST /userRoutes
     *
     * @param CreateUserRouteAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateUserRouteAPIRequest $request)
    {
        $input = $request->all();

        $userRoute = $this->userRouteRepository->create($input);

        return $this->sendResponse($userRoute->toArray(), 'User Route saved successfully');
    }

    /**
     * Display the specified UserRoute.
     * GET|HEAD /userRoutes/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var UserRoute $userRoute */
        $userRoute = $this->userRouteRepository->find($id);

        if (empty($userRoute)) {
            return $this->sendError('User Route not found');
        }

        return $this->sendResponse($userRoute->toArray(), 'User Route retrieved successfully');
    }

    /**
     * Update the specified UserRoute in storage.
     * PUT/PATCH /userRoutes/{id}
     *
     * @param int $id
     * @param UpdateUserRouteAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUserRouteAPIRequest $request)
    {
        $input = $request->all();

        /** @var UserRoute $userRoute */
        $userRoute = $this->userRouteRepository->find($id);

        if (empty($userRoute)) {
            return $this->sendError('User Route not found');
        }

        $userRoute = $this->userRouteRepository->update($input, $id);

        return $this->sendResponse($userRoute->toArray(), 'UserRoute updated successfully');
    }

    /**
     * Remove the specified UserRoute from storage.
     * DELETE /userRoutes/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var UserRoute $userRoute */
        $userRoute = $this->userRouteRepository->find($id);

        if (empty($userRoute)) {
            return $this->sendError('User Route not found');
        }

        $userRoute->delete();

        return $this->sendSuccess('User Route deleted successfully');
    }
}

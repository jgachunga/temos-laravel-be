<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\API\V1\CreateRouteAPIRequest;
use App\Http\Requests\API\V1\UpdateRouteAPIRequest;
use App\Models\Route;
use App\Repositories\Backend\RouteRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Models\Auth\User;
use Illuminate\Support\Facades\Auth;
use App\Models\UserRoute;
use Response;

/**
 * Class RouteController
 * @package App\Http\Controllers\API\V1
 */

class RouteAPIController extends AppBaseController
{
    /** @var  RouteRepository */
    private $routeRepository;

    public function __construct(RouteRepository $routeRepo)
    {
        $this->routeRepository = $routeRepo;
    }

    /**
     * Display a listing of the Route.
     * GET|HEAD /routes
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $page = $request->only('page');
        if(isset($page)&&!empty($page)){
            $routes = Route::with('stockist')->orderByDesc('created_at')->paginate(5);
        }else{
            $routes = $this->routeRepository->with('stockist')->all(
                $request->except(['skip', 'limit']),
                $request->get('skip'),
                $request->get('limit')
            );
        }

        return $this->sendResponse($routes->toArray(), 'Routes retrieved successfully');
    }

    public function routeByUser()
    {
        $user_id = Auth::guard('api')->user()->id;
        $routes = $this->routeRepository->getbyUserId($user_id);

        return $this->sendResponse($routes->toArray(), 'Routes retrieved successfully');
    }

    /**
     * Store a newly created Route in storage.
     * POST /routes
     *
     * @param CreateRouteAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateRouteAPIRequest $request)
    {
        $input = $request->all();

        $route = $this->routeRepository->create($input);

        return $this->sendResponse($route->toArray(), 'Route saved successfully');
    }

    /**
     * Display the specified Route.
     * GET|HEAD /routes/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Route $route */
        $route = $this->routeRepository->find($id);

        if (empty($route)) {
            return $this->sendError('Route not found');
        }

        return $this->sendResponse($route->toArray(), 'Route retrieved successfully');
    }

    /**
     * Update the specified Route in storage.
     * PUT/PATCH /routes/{id}
     *
     * @param int $id
     * @param UpdateRouteAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateRouteAPIRequest $request)
    {
        $input = $request->all();

        /** @var Route $route */
        $route = $this->routeRepository->find($id);

        if (empty($route)) {
            return $this->sendError('Route not found');
        }

        $route = $this->routeRepository->update($input, $id);

        return $this->sendResponse($route->toArray(), 'Route updated successfully');
    }

    /**
     * Remove the specified Route from storage.
     * DELETE /routes/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Route $route */
        $route = $this->routeRepository->find($id);

        if (empty($route)) {
            return $this->sendError('Route not found');
        }

        $route->delete();

        return $this->sendResponse($id, 'Route deleted successfully');
    }
    public function assign(Request $request, $user_id)
    {
        /** @var Route $route */
        $input = $request->all();
        $selected = $input['selected'];
        foreach($selected as $route_id){
            $user_route = UserRoute::where("user_id", $user_id)->where("route_id", $route_id)->first();
            if (empty($user_route)) {
                UserRoute::create([
                    "user_id" => $user_id,
                    "route_id" => $route_id
                ]);
            }else{
                $user_route->delete();
            }
        }


        return $this->sendResponse($user_route, 'Route assigned successfully');
    }
}

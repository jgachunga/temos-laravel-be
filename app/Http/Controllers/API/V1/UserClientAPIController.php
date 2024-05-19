<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\API\V1\CreateUserClientAPIRequest;
use App\Http\Requests\API\V1\UpdateUserClientAPIRequest;
use App\Models\UserClient;
use App\Repositories\Backend\UserClientRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\UserClientResource;
use Illuminate\Support\Facades\Auth;
use Response;

/**
 * Class UserClientController
 * @package App\Http\Controllers\API\V1
 */

class UserClientAPIController extends AppBaseController
{
    /** @var  UserClientRepository */
    private $userClientRepository;

    public function __construct(UserClientRepository $userClientRepo)
    {
        $this->userClientRepository = $userClientRepo;
    }

    /**
     * Display a listing of the UserClient.
     * GET|HEAD /userClients
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $user_id = Auth::guard('api')->user()->id;
        $userClients = $this->userClientRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        )->where('user_id', $user_id);

        return $this->sendResponse(UserClientResource::collection($userClients), 'User Clients retrieved successfully');
    }

    /**
     * Store a newly created UserClient in storage.
     * POST /userClients
     *
     * @param CreateUserClientAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateUserClientAPIRequest $request)
    {
        $input = $request->all();

        $userClient = $this->userClientRepository->create($input);

        return $this->sendResponse(new UserClientResource($userClient), 'User Client saved successfully');
    }

    /**
     * Display the specified UserClient.
     * GET|HEAD /userClients/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var UserClient $userClient */
        $userClient = $this->userClientRepository->find($id);

        if (empty($userClient)) {
            return $this->sendError('User Client not found');
        }

        return $this->sendResponse(new UserClientResource($userClient), 'User Client retrieved successfully');
    }

    /**
     * Update the specified UserClient in storage.
     * PUT/PATCH /userClients/{id}
     *
     * @param int $id
     * @param UpdateUserClientAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUserClientAPIRequest $request)
    {
        $input = $request->all();

        /** @var UserClient $userClient */
        $userClient = $this->userClientRepository->find($id);

        if (empty($userClient)) {
            return $this->sendError('User Client not found');
        }

        $userClient = $this->userClientRepository->update($input, $id);

        return $this->sendResponse(new UserClientResource($userClient), 'UserClient updated successfully');
    }

    /**
     * Remove the specified UserClient from storage.
     * DELETE /userClients/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var UserClient $userClient */
        $userClient = $this->userClientRepository->find($id);

        if (empty($userClient)) {
            return $this->sendError('User Client not found');
        }

        $userClient->delete();

        return $this->sendSuccess('User Client deleted successfully');
    }
}

<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\API\V1\CreateUserStatusAPIRequest;
use App\Http\Requests\API\V1\UpdateUserStatusAPIRequest;
use App\Models\UserStatus;
use App\Repositories\Backend\UserStatusRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class UserStatusController
 * @package App\Http\Controllers\API\V1
 */

class UserStatusAPIController extends AppBaseController
{
    /** @var  UserStatusRepository */
    private $userStatusRepository;

    public function __construct(UserStatusRepository $userStatusRepo)
    {
        $this->userStatusRepository = $userStatusRepo;
    }

    /**
     * Display a listing of the UserStatus.
     * GET|HEAD /userStatuses
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $userStatuses = $this->userStatusRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($userStatuses->toArray(), 'User Statuses retrieved successfully');
    }

    /**
     * Store a newly created UserStatus in storage.
     * POST /userStatuses
     *
     * @param CreateUserStatusAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateUserStatusAPIRequest $request)
    {
        $input = $request->all();

        $userStatus = $this->userStatusRepository->create($input);

        return $this->sendResponse($userStatus->toArray(), 'User Status saved successfully');
    }

    /**
     * Display the specified UserStatus.
     * GET|HEAD /userStatuses/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var UserStatus $userStatus */
        $userStatus = $this->userStatusRepository->find($id);

        if (empty($userStatus)) {
            return $this->sendError('User Status not found');
        }

        return $this->sendResponse($userStatus->toArray(), 'User Status retrieved successfully');
    }

    /**
     * Update the specified UserStatus in storage.
     * PUT/PATCH /userStatuses/{id}
     *
     * @param int $id
     * @param UpdateUserStatusAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUserStatusAPIRequest $request)
    {
        $input = $request->all();

        /** @var UserStatus $userStatus */
        $userStatus = $this->userStatusRepository->find($id);

        if (empty($userStatus)) {
            return $this->sendError('User Status not found');
        }

        $userStatus = $this->userStatusRepository->update($input, $id);

        return $this->sendResponse($userStatus->toArray(), 'UserStatus updated successfully');
    }

    /**
     * Remove the specified UserStatus from storage.
     * DELETE /userStatuses/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var UserStatus $userStatus */
        $userStatus = $this->userStatusRepository->find($id);

        if (empty($userStatus)) {
            return $this->sendError('User Status not found');
        }

        $userStatus->delete();

        return $this->sendResponse($id, 'User Status deleted successfully');
    }
}

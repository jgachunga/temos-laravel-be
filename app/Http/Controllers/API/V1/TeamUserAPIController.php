<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\API\V1\CreateTeamUserAPIRequest;
use App\Http\Requests\API\V1\UpdateTeamUserAPIRequest;
use App\Models\TeamUser;
use App\Repositories\Backend\TeamUserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class TeamUserController
 * @package App\Http\Controllers\API\V1
 */

class TeamUserAPIController extends AppBaseController
{
    /** @var  TeamUserRepository */
    private $teamUserRepository;

    public function __construct(TeamUserRepository $teamUserRepo)
    {
        $this->teamUserRepository = $teamUserRepo;
    }

    /**
     * Display a listing of the TeamUser.
     * GET|HEAD /teamUsers
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $teamUsers = $this->teamUserRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($teamUsers->toArray(), 'Team Users retrieved successfully');
    }

    /**
     * Store a newly created TeamUser in storage.
     * POST /teamUsers
     *
     * @param CreateTeamUserAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateTeamUserAPIRequest $request)
    {
        $input = $request->all();

        $teamUser = $this->teamUserRepository->create($input);

        return $this->sendResponse($teamUser->toArray(), 'Team User saved successfully');
    }

    /**
     * Display the specified TeamUser.
     * GET|HEAD /teamUsers/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var TeamUser $teamUser */
        $teamUser = $this->teamUserRepository->find($id);

        if (empty($teamUser)) {
            return $this->sendError('Team User not found');
        }

        return $this->sendResponse($teamUser->toArray(), 'Team User retrieved successfully');
    }

    /**
     * Update the specified TeamUser in storage.
     * PUT/PATCH /teamUsers/{id}
     *
     * @param int $id
     * @param UpdateTeamUserAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTeamUserAPIRequest $request)
    {
        $input = $request->all();

        /** @var TeamUser $teamUser */
        $teamUser = $this->teamUserRepository->find($id);

        if (empty($teamUser)) {
            return $this->sendError('Team User not found');
        }

        $teamUser = $this->teamUserRepository->update($input, $id);

        return $this->sendResponse($teamUser->toArray(), 'TeamUser updated successfully');
    }

    /**
     * Remove the specified TeamUser from storage.
     * DELETE /teamUsers/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var TeamUser $teamUser */
        $teamUser = $this->teamUserRepository->find($id);

        if (empty($teamUser)) {
            return $this->sendError('Team User not found');
        }

        $teamUser->delete();

        return $this->sendResponse($id, 'Team User deleted successfully');
    }
}

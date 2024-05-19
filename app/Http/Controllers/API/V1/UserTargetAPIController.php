<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\API\V1\CreateUserTargetAPIRequest;
use App\Http\Requests\API\V1\UpdateUserTargetAPIRequest;
use App\Models\UserTarget;
use App\Repositories\Backend\UserTargetRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class UserTargetController
 * @package App\Http\Controllers\API\V1
 */

class UserTargetAPIController extends AppBaseController
{
    /** @var  UserTargetRepository */
    private $userTargetRepository;

    public function __construct(UserTargetRepository $userTargetRepo)
    {
        $this->userTargetRepository = $userTargetRepo;
    }

    /**
     * Display a listing of the UserTarget.
     * GET|HEAD /userTargets
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $page = $request->only('page');
        if(isset($page)&&!empty($page)){
            $userTargets = UserTarget::with('user')->orderByDesc('created_at')->paginate(5);
        }else{
            $userTargets = $this->userTargetRepository->with('user')->all(
                $request->except(['skip', 'limit']),
                $request->get('skip'),
                $request->get('limit')
            );
        }

        return $this->sendResponse($userTargets->toArray(), 'User Targets retrieved successfully');
    }

    /**
     * Store a newly created UserTarget in storage.
     * POST /userTargets
     *
     * @param CreateUserTargetAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateUserTargetAPIRequest $request)
    {
        $input = $request->all();

        $userTarget = $this->userTargetRepository->create($input);

        return $this->sendResponse($userTarget->toArray(), 'User Target saved successfully');
    }

    /**
     * Display the specified UserTarget.
     * GET|HEAD /userTargets/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var UserTarget $userTarget */
        $userTarget = $this->userTargetRepository->find($id);

        if (empty($userTarget)) {
            return $this->sendError('User Target not found');
        }

        return $this->sendResponse($userTarget->toArray(), 'User Target retrieved successfully');
    }

    /**
     * Update the specified UserTarget in storage.
     * PUT/PATCH /userTargets/{id}
     *
     * @param int $id
     * @param UpdateUserTargetAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUserTargetAPIRequest $request)
    {
        $input = $request->all();

        /** @var UserTarget $userTarget */
        $userTarget = $this->userTargetRepository->find($id);

        if (empty($userTarget)) {
            return $this->sendError('User Target not found');
        }

        $userTarget = $this->userTargetRepository->update($input, $id);

        return $this->sendResponse($userTarget->toArray(), 'UserTarget updated successfully');
    }

    /**
     * Remove the specified UserTarget from storage.
     * DELETE /userTargets/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var UserTarget $userTarget */
        $userTarget = $this->userTargetRepository->find($id);

        if (empty($userTarget)) {
            return $this->sendError('User Target not found');
        }

        $userTarget->delete();

        return $this->sendResponse($id, 'User Target deleted successfully');
    }
}

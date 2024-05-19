<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\API\V1\CreateUserDeviceInfoAPIRequest;
use App\Http\Requests\API\V1\UpdateUserDeviceInfoAPIRequest;
use App\Models\UserDeviceInfo;
use App\Repositories\Backend\UserDeviceInfoRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Models\Auth\User;
use Response;

/**
 * Class UserDeviceInfoController
 * @package App\Http\Controllers\API\V1
 */

class UserDeviceInfoAPIController extends AppBaseController
{
    /** @var  UserDeviceInfoRepository */
    private $userDeviceInfoRepository;

    public function __construct(UserDeviceInfoRepository $userDeviceInfoRepo)
    {
        $this->userDeviceInfoRepository = $userDeviceInfoRepo;
    }

    /**
     * Display a listing of the UserDeviceInfo.
     * GET|HEAD /userDeviceInfos
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $userDeviceInfos = $this->userDeviceInfoRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($userDeviceInfos->toArray(), 'User Device Infos retrieved successfully');
    }
    public function list(Request $request)
    {
        $structures = $request->get('structures');
        $user_ids = User::whereIn('structure_id', $structures)->pluck('id');
        $user_infos = UserDeviceInfo::with('user', 'imei', 'clockins', 'locations', 'user.structure')->whereIn('user_id', $user_ids)->orderByDesc('created_at')->limit(100)->paginate(5);

        return $this->sendResponse($user_infos->toArray(), 'UserInfo retrieved successfully');
    }
    /**
     * Store a newly created UserDeviceInfo in storage.
     * POST /userDeviceInfos
     *
     * @param CreateUserDeviceInfoAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateUserDeviceInfoAPIRequest $request)
    {
        $input = $request->all();
        $userDeviceInfo = $this->userDeviceInfoRepository->create($input);

        return $this->sendResponse($userDeviceInfo->toArray(), 'User Device Info saved successfully');
    }

    /**
     * Display the specified UserDeviceInfo.
     * GET|HEAD /userDeviceInfos/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var UserDeviceInfo $userDeviceInfo */
        $userDeviceInfo = $this->userDeviceInfoRepository->find($id);

        if (empty($userDeviceInfo)) {
            return $this->sendError('User Device Info not found');
        }

        return $this->sendResponse($userDeviceInfo->toArray(), 'User Device Info retrieved successfully');
    }

    /**
     * Update the specified UserDeviceInfo in storage.
     * PUT/PATCH /userDeviceInfos/{id}
     *
     * @param int $id
     * @param UpdateUserDeviceInfoAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUserDeviceInfoAPIRequest $request)
    {
        $input = $request->all();

        /** @var UserDeviceInfo $userDeviceInfo */
        $userDeviceInfo = $this->userDeviceInfoRepository->find($id);

        if (empty($userDeviceInfo)) {
            return $this->sendError('User Device Info not found');
        }

        $userDeviceInfo = $this->userDeviceInfoRepository->update($input, $id);

        return $this->sendResponse($userDeviceInfo->toArray(), 'UserDeviceInfo updated successfully');
    }

    /**
     * Remove the specified UserDeviceInfo from storage.
     * DELETE /userDeviceInfos/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var UserDeviceInfo $userDeviceInfo */
        $userDeviceInfo = $this->userDeviceInfoRepository->find($id);

        if (empty($userDeviceInfo)) {
            return $this->sendError('User Device Info not found');
        }

        $userDeviceInfo->delete();

        return $this->sendResponse($id, 'User Device Info deleted successfully');
    }
}

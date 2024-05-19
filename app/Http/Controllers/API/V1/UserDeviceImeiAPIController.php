<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\API\V1\CreateUserDeviceImeiAPIRequest;
use App\Http\Requests\API\V1\UpdateUserDeviceImeiAPIRequest;
use App\Models\UserDeviceImei;
use App\Repositories\Backend\UserDeviceImeiRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class UserDeviceImeiController
 * @package App\Http\Controllers\API\V1
 */

class UserDeviceImeiAPIController extends AppBaseController
{
    /** @var  UserDeviceImeiRepository */
    private $userDeviceImeiRepository;

    public function __construct(UserDeviceImeiRepository $userDeviceImeiRepo)
    {
        $this->userDeviceImeiRepository = $userDeviceImeiRepo;
    }

    /**
     * Display a listing of the UserDeviceImei.
     * GET|HEAD /userDeviceImeis
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $userDeviceImeis = $this->userDeviceImeiRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($userDeviceImeis->toArray(), 'User Device Imeis retrieved successfully');
    }

    /**
     * Store a newly created UserDeviceImei in storage.
     * POST /userDeviceImeis
     *
     * @param CreateUserDeviceImeiAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateUserDeviceImeiAPIRequest $request)
    {
        $input = $request->all();

        $userDeviceImei = $this->userDeviceImeiRepository->create($input);

        return $this->sendResponse($userDeviceImei->toArray(), 'User Device Imei saved successfully');
    }

    /**
     * Display the specified UserDeviceImei.
     * GET|HEAD /userDeviceImeis/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var UserDeviceImei $userDeviceImei */
        $userDeviceImei = $this->userDeviceImeiRepository->find($id);

        if (empty($userDeviceImei)) {
            return $this->sendError('User Device Imei not found');
        }

        return $this->sendResponse($userDeviceImei->toArray(), 'User Device Imei retrieved successfully');
    }

    /**
     * Update the specified UserDeviceImei in storage.
     * PUT/PATCH /userDeviceImeis/{id}
     *
     * @param int $id
     * @param UpdateUserDeviceImeiAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUserDeviceImeiAPIRequest $request)
    {
        $input = $request->all();

        /** @var UserDeviceImei $userDeviceImei */
        $userDeviceImei = $this->userDeviceImeiRepository->find($id);

        if (empty($userDeviceImei)) {
            return $this->sendError('User Device Imei not found');
        }

        $userDeviceImei = $this->userDeviceImeiRepository->update($input, $id);

        return $this->sendResponse($userDeviceImei->toArray(), 'UserDeviceImei updated successfully');
    }

    /**
     * Remove the specified UserDeviceImei from storage.
     * DELETE /userDeviceImeis/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var UserDeviceImei $userDeviceImei */
        $userDeviceImei = $this->userDeviceImeiRepository->find($id);

        if (empty($userDeviceImei)) {
            return $this->sendError('User Device Imei not found');
        }

        $userDeviceImei->delete();

        return $this->sendResponse($id, 'User Device Imei deleted successfully');
    }
}

<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\API\V1\CreateUserLocationHistoryAPIRequest;
use App\Http\Requests\API\V1\UpdateUserLocationHistoryAPIRequest;
use App\Models\UserLocationHistory;
use App\Repositories\Backend\UserLocationHistoryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Models\Auth\User;
use Response;

/**
 * Class UserLocationHistoryController
 * @package App\Http\Controllers\API\V1
 */

class UserLocationHistoryAPIController extends AppBaseController
{
    /** @var  UserLocationHistoryRepository */
    private $userLocationHistoryRepository;

    public function __construct(UserLocationHistoryRepository $userLocationHistoryRepo)
    {
        $this->userLocationHistoryRepository = $userLocationHistoryRepo;
    }

    /**
     * Display a listing of the UserLocationHistory.
     * GET|HEAD /userLocationHistories
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $userLocationHistories = $this->userLocationHistoryRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($userLocationHistories->toArray(), 'User Location Histories retrieved successfully');
    }
    public function list(Request $request)
    {
        $structures = $request->get('structures');
        $user_ids = User::whereIn('structure_id', $structures)->pluck('id');
        $locations = UserLocationHistory::with('customer', 'current_status', 'user', 'clockins')->whereIn('user_id', $user_ids)->orderByDesc('created_at')->limit(100)->get();

        return $this->sendResponse($locations->toArray(), 'Invoices retrieved successfully');
    }
    public function listIndividual(Request $request)
    {
        $structures = $request->get('structures');
        $user_ids = User::whereIn('structure_id', $structures)->pluck('id');
        
        $locations = UserLocationHistory::whereIn('id', function($query) {
            $query->from('user_location_history')->groupBy('user_id')->selectRaw('MAX(id)');
         })->with('customer', 'current_status', 'user', 'clockins')->get();

        return $this->sendResponse($locations->toArray(), 'Invoices retrieved successfully');
    }
    /**
     * Store a newly created UserLocationHistory in storage.
     * POST /userLocationHistories
     *
     * @param CreateUserLocationHistoryAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateUserLocationHistoryAPIRequest $request)
    {
        $input = $request->all();

        $userLocationHistory = $this->userLocationHistoryRepository->create($input);

        return $this->sendResponse($userLocationHistory->toArray(), 'User Location History saved successfully');
    }

    /**
     * Display the specified UserLocationHistory.
     * GET|HEAD /userLocationHistories/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var UserLocationHistory $userLocationHistory */
        $userLocationHistory = $this->userLocationHistoryRepository->find($id);

        if (empty($userLocationHistory)) {
            return $this->sendError('User Location History not found');
        }

        return $this->sendResponse($userLocationHistory->toArray(), 'User Location History retrieved successfully');
    }

    /**
     * Update the specified UserLocationHistory in storage.
     * PUT/PATCH /userLocationHistories/{id}
     *
     * @param int $id
     * @param UpdateUserLocationHistoryAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUserLocationHistoryAPIRequest $request)
    {
        $input = $request->all();

        /** @var UserLocationHistory $userLocationHistory */
        $userLocationHistory = $this->userLocationHistoryRepository->find($id);

        if (empty($userLocationHistory)) {
            return $this->sendError('User Location History not found');
        }

        $userLocationHistory = $this->userLocationHistoryRepository->update($input, $id);

        return $this->sendResponse($userLocationHistory->toArray(), 'UserLocationHistory updated successfully');
    }

    /**
     * Remove the specified UserLocationHistory from storage.
     * DELETE /userLocationHistories/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var UserLocationHistory $userLocationHistory */
        $userLocationHistory = $this->userLocationHistoryRepository->find($id);

        if (empty($userLocationHistory)) {
            return $this->sendError('User Location History not found');
        }

        $userLocationHistory->delete();

        return $this->sendResponse($id, 'User Location History deleted successfully');
    }
}

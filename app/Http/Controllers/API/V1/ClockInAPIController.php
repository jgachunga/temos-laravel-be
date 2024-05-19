<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\API\V1\CreateClockInAPIRequest;
use App\Http\Requests\API\V1\UpdateClockInAPIRequest;
use App\Models\ClockIn;
use App\Repositories\Backend\ClockInRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Models\Auth\User;
use Illuminate\Support\Facades\Log;
use Response;

/**
 * Class ClockInController
 * @package App\Http\Controllers\API\V1
 */

class ClockInAPIController extends AppBaseController
{
    /** @var  ClockInRepository */
    private $clockInRepository;

    public function __construct(ClockInRepository $clockInRepo)
    {
        $this->clockInRepository = $clockInRepo;
    }

    public function isClockedIn(){
        $clockedIn = $this->clockInRepository->ClockInExists();
        return $this->sendResponse($clockedIn, 'Clocked In');
    }

    /**
     * Display a listing of the ClockIn.
     * GET|HEAD /clockIns
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $clockIns = $this->clockInRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($clockIns->toArray(), 'Clock Ins retrieved successfully');
    }
    public function list(Request $request)
    {
        $structures = $request->get('structures');
        $user_ids = User::whereIn('structure_id', $structures)->pluck('id');
        $user_infos = ClockIn::with('user', 'clocktype', 'user.structure')->whereIn('user_id', $user_ids)->orderByDesc('created_at')->paginate(5);

        return $this->sendResponse($user_infos->toArray(), 'UserInfo retrieved successfully');
    }

    /**
     * Store a newly created ClockIn in storage.
     * POST /clockIns
     *
     * @param CreateClockInAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateClockInAPIRequest $request)
    {
        $input = $request->all();
        $clockIn = $this->clockInRepository->create($input);
        return $this->sendResponse(['url' => $clockIn->img_url], 'Clock In saved successfully');
    }

    /**
     * Display the specified ClockIn.
     * GET|HEAD /clockIns/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var ClockIn $clockIn */
        $clockIn = $this->clockInRepository->find($id);

        if (empty($clockIn)) {
            return $this->sendError('Clock In not found');
        }

        return $this->sendResponse($clockIn->toArray(), 'Clock In retrieved successfully');
    }

    /**
     * Update the specified ClockIn in storage.
     * PUT/PATCH /clockIns/{id}
     *
     * @param int $id
     * @param UpdateClockInAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateClockInAPIRequest $request)
    {
        $input = $request->all();

        /** @var ClockIn $clockIn */
        $clockIn = $this->clockInRepository->find($id);

        if (empty($clockIn)) {
            return $this->sendError('Clock In not found');
        }

        $clockIn = $this->clockInRepository->update($input, $id);

        return $this->sendResponse($clockIn->toArray(), 'ClockIn updated successfully');
    }

    /**
     * Remove the specified ClockIn from storage.
     * DELETE /clockIns/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var ClockIn $clockIn */
        $clockIn = $this->clockInRepository->find($id);

        if (empty($clockIn)) {
            return $this->sendError('Clock In not found');
        }

        $clockIn->delete();

        return $this->sendResponse($id, 'Clock In deleted successfully');
    }
}

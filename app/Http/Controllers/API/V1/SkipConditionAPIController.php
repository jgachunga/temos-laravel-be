<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\API\V1\CreateSkipConditionAPIRequest;
use App\Http\Requests\API\V1\UpdateSkipConditionAPIRequest;
use App\Models\SkipCondition;
use App\Repositories\Backend\SkipConditionRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class SkipConditionController
 * @package App\Http\Controllers\API\V1
 */

class SkipConditionAPIController extends AppBaseController
{
    /** @var  SkipConditionRepository */
    private $skipConditionRepository;

    public function __construct(SkipConditionRepository $skipConditionRepo)
    {
        $this->skipConditionRepository = $skipConditionRepo;
    }

    /**
     * Display a listing of the SkipCondition.
     * GET|HEAD /skipConditions
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $skipConditions = $this->skipConditionRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($skipConditions->toArray(), 'Skip Conditions retrieved successfully');
    }

    /**
     * Store a newly created SkipCondition in storage.
     * POST /skipConditions
     *
     * @param CreateSkipConditionAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateSkipConditionAPIRequest $request)
    {
        $input = $request->all();

        $skipCondition = $this->skipConditionRepository->create($input);

        return $this->sendResponse($skipCondition->toArray(), 'Skip Condition saved successfully');
    }

    /**
     * Display the specified SkipCondition.
     * GET|HEAD /skipConditions/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var SkipCondition $skipCondition */
        $skipCondition = $this->skipConditionRepository->find($id);

        if (empty($skipCondition)) {
            return $this->sendError('Skip Condition not found');
        }

        return $this->sendResponse($skipCondition->toArray(), 'Skip Condition retrieved successfully');
    }

    /**
     * Update the specified SkipCondition in storage.
     * PUT/PATCH /skipConditions/{id}
     *
     * @param int $id
     * @param UpdateSkipConditionAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSkipConditionAPIRequest $request)
    {
        $input = $request->all();

        /** @var SkipCondition $skipCondition */
        $skipCondition = $this->skipConditionRepository->find($id);

        if (empty($skipCondition)) {
            return $this->sendError('Skip Condition not found');
        }

        $skipCondition = $this->skipConditionRepository->update($input, $id);

        return $this->sendResponse($skipCondition->toArray(), 'SkipCondition updated successfully');
    }

    /**
     * Remove the specified SkipCondition from storage.
     * DELETE /skipConditions/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var SkipCondition $skipCondition */
        $skipCondition = $this->skipConditionRepository->find($id);

        if (empty($skipCondition)) {
            return $this->sendError('Skip Condition not found');
        }

        $skipCondition->delete();

        return $this->sendSuccess('Skip Condition deleted successfully');
    }
}

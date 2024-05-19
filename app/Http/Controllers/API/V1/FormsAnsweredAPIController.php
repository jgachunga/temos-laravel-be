<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\API\V1\CreateFormsAnsweredAPIRequest;
use App\Http\Requests\API\V1\UpdateFormsAnsweredAPIRequest;
use App\Models\FormsAnswered;
use App\Repositories\Backend\FormsAnsweredRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class FormsAnsweredController
 * @package App\Http\Controllers\API\V1
 */

class FormsAnsweredAPIController extends AppBaseController
{
    /** @var  FormsAnsweredRepository */
    private $formsAnsweredRepository;

    public function __construct(FormsAnsweredRepository $formsAnsweredRepo)
    {
        $this->formsAnsweredRepository = $formsAnsweredRepo;
    }

    /**
     * Display a listing of the FormsAnswered.
     * GET|HEAD /formsAnswereds
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $formsAnswereds = $this->formsAnsweredRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($formsAnswereds->toArray(), 'Forms Answereds retrieved successfully');
    }

    /**
     * Store a newly created FormsAnswered in storage.
     * POST /formsAnswereds
     *
     * @param CreateFormsAnsweredAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateFormsAnsweredAPIRequest $request)
    {
        $input = $request->all();

        $formsAnswered = $this->formsAnsweredRepository->create($input);

        return $this->sendResponse($formsAnswered->toArray(), 'Forms Answered saved successfully');
    }

    /**
     * Display the specified FormsAnswered.
     * GET|HEAD /formsAnswereds/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var FormsAnswered $formsAnswered */
        $formsAnswered = $this->formsAnsweredRepository->find($id);

        if (empty($formsAnswered)) {
            return $this->sendError('Forms Answered not found');
        }

        return $this->sendResponse($formsAnswered->toArray(), 'Forms Answered retrieved successfully');
    }

    /**
     * Update the specified FormsAnswered in storage.
     * PUT/PATCH /formsAnswereds/{id}
     *
     * @param int $id
     * @param UpdateFormsAnsweredAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateFormsAnsweredAPIRequest $request)
    {
        $input = $request->all();

        /** @var FormsAnswered $formsAnswered */
        $formsAnswered = $this->formsAnsweredRepository->find($id);

        if (empty($formsAnswered)) {
            return $this->sendError('Forms Answered not found');
        }

        $formsAnswered = $this->formsAnsweredRepository->update($input, $id);

        return $this->sendResponse($formsAnswered->toArray(), 'FormsAnswered updated successfully');
    }

    /**
     * Remove the specified FormsAnswered from storage.
     * DELETE /formsAnswereds/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var FormsAnswered $formsAnswered */
        $formsAnswered = $this->formsAnsweredRepository->find($id);

        if (empty($formsAnswered)) {
            return $this->sendError('Forms Answered not found');
        }

        $formsAnswered->delete();

        return $this->sendResponse($id, 'Forms Answered deleted successfully');
    }
}

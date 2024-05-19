<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\API\V1\CreateFormsAnswerOptionsAPIRequest;
use App\Http\Requests\API\V1\UpdateFormsAnswerOptionsAPIRequest;
use App\Models\FormsAnswerOptions;
use App\Repositories\Backend\FormsAnswerOptionsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class FormsAnswerOptionsController
 * @package App\Http\Controllers\API\V1
 */

class FormsAnswerOptionsAPIController extends AppBaseController
{
    /** @var  FormsAnswerOptionsRepository */
    private $formsAnswerOptionsRepository;

    public function __construct(FormsAnswerOptionsRepository $formsAnswerOptionsRepo)
    {
        $this->formsAnswerOptionsRepository = $formsAnswerOptionsRepo;
    }

    /**
     * Display a listing of the FormsAnswerOptions.
     * GET|HEAD /formsAnswerOptions
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $formsAnswerOptions = $this->formsAnswerOptionsRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($formsAnswerOptions->toArray(), 'Forms Answer Options retrieved successfully');
    }

    /**
     * Store a newly created FormsAnswerOptions in storage.
     * POST /formsAnswerOptions
     *
     * @param CreateFormsAnswerOptionsAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateFormsAnswerOptionsAPIRequest $request)
    {
        $input = $request->all();

        $formsAnswerOptions = $this->formsAnswerOptionsRepository->create($input);

        return $this->sendResponse($formsAnswerOptions->toArray(), 'Forms Answer Options saved successfully');
    }

    /**
     * Display the specified FormsAnswerOptions.
     * GET|HEAD /formsAnswerOptions/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var FormsAnswerOptions $formsAnswerOptions */
        $formsAnswerOptions = $this->formsAnswerOptionsRepository->find($id);

        if (empty($formsAnswerOptions)) {
            return $this->sendError('Forms Answer Options not found');
        }

        return $this->sendResponse($formsAnswerOptions->toArray(), 'Forms Answer Options retrieved successfully');
    }

    /**
     * Update the specified FormsAnswerOptions in storage.
     * PUT/PATCH /formsAnswerOptions/{id}
     *
     * @param int $id
     * @param UpdateFormsAnswerOptionsAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateFormsAnswerOptionsAPIRequest $request)
    {
        $input = $request->all();

        /** @var FormsAnswerOptions $formsAnswerOptions */
        $formsAnswerOptions = $this->formsAnswerOptionsRepository->find($id);

        if (empty($formsAnswerOptions)) {
            return $this->sendError('Forms Answer Options not found');
        }

        $formsAnswerOptions = $this->formsAnswerOptionsRepository->update($input, $id);

        return $this->sendResponse($formsAnswerOptions->toArray(), 'FormsAnswerOptions updated successfully');
    }

    /**
     * Remove the specified FormsAnswerOptions from storage.
     * DELETE /formsAnswerOptions/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var FormsAnswerOptions $formsAnswerOptions */
        $formsAnswerOptions = $this->formsAnswerOptionsRepository->find($id);

        if (empty($formsAnswerOptions)) {
            return $this->sendError('Forms Answer Options not found');
        }

        $formsAnswerOptions->delete();

        return $this->sendResponse($id, 'Forms Answer Options deleted successfully');
    }
}

<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\API\V1\CreateQuestionOptionAPIRequest;
use App\Http\Requests\API\V1\UpdateQuestionOptionAPIRequest;
use App\Models\QuestionOption;
use App\Repositories\Backend\QuestionOptionRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class QuestionOptionController
 * @package App\Http\Controllers\API\V1
 */

class QuestionOptionAPIController extends AppBaseController
{
    /** @var  QuestionOptionRepository */
    private $questionOptionRepository;

    public function __construct(QuestionOptionRepository $questionOptionRepo)
    {
        $this->questionOptionRepository = $questionOptionRepo;
    }

    /**
     * Display a listing of the QuestionOption.
     * GET|HEAD /questionOptions
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $questionOptions = $this->questionOptionRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($questionOptions->toArray(), 'Question Options retrieved successfully');
    }

    /**
     * Store a newly created QuestionOption in storage.
     * POST /questionOptions
     *
     * @param CreateQuestionOptionAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateQuestionOptionAPIRequest $request)
    {
        $input = $request->all();

        $questionOption = $this->questionOptionRepository->create($input);

        return $this->sendResponse($questionOption->toArray(), 'Question Option saved successfully');
    }

    /**
     * Display the specified QuestionOption.
     * GET|HEAD /questionOptions/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var QuestionOption $questionOption */
        $questionOption = $this->questionOptionRepository->find($id);

        if (empty($questionOption)) {
            return $this->sendError('Question Option not found');
        }

        return $this->sendResponse($questionOption->toArray(), 'Question Option retrieved successfully');
    }

    /**
     * Update the specified QuestionOption in storage.
     * PUT/PATCH /questionOptions/{id}
     *
     * @param int $id
     * @param UpdateQuestionOptionAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateQuestionOptionAPIRequest $request)
    {
        $input = $request->all();

        /** @var QuestionOption $questionOption */
        $questionOption = $this->questionOptionRepository->find($id);

        if (empty($questionOption)) {
            return $this->sendError('Question Option not found');
        }

        $questionOption = $this->questionOptionRepository->update($input, $id);

        return $this->sendResponse($questionOption->toArray(), 'QuestionOption updated successfully');
    }

    /**
     * Remove the specified QuestionOption from storage.
     * DELETE /questionOptions/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var QuestionOption $questionOption */
        $questionOption = $this->questionOptionRepository->find($id);

        if (empty($questionOption)) {
            return $this->sendError('Question Option not found');
        }

        $questionOption->delete();

        return $this->sendResponse($id, 'Question Option deleted successfully');
    }
}

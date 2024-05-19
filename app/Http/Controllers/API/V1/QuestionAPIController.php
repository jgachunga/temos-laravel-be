<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\API\V1\CreateQuestionAPIRequest;
use App\Http\Requests\API\V1\UpdateQuestionAPIRequest;
use App\Models\Question;
use App\Repositories\Backend\QuestionRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class QuestionController
 * @package App\Http\Controllers\API\V1
 */

class QuestionAPIController extends AppBaseController
{
    /** @var  QuestionRepository */
    private $questionRepository;

    public function __construct(QuestionRepository $questionRepo)
    {
        $this->questionRepository = $questionRepo;
    }

    /**
     * Display a listing of the Question.
     * GET|HEAD /questions
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $questions = $this->questionRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($questions->toArray(), 'Questions retrieved successfully');
    }

    /**
     * Store a newly created Question in storage.
     * POST /questions
     *
     * @param CreateQuestionAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateQuestionAPIRequest $request)
    {
        $input = $request->all();

        $question = $this->questionRepository->create($input);

        return $this->sendResponse($question->toArray(), 'Question saved successfully');
    }

    /**
     * Display the specified Question.
     * GET|HEAD /questions/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Question $question */
        $question = $this->questionRepository->find($id);

        if (empty($question)) {
            return $this->sendError('Question not found');
        }

        return $this->sendResponse($question->toArray(), 'Question retrieved successfully');
    }

    /**
     * Update the specified Question in storage.
     * PUT/PATCH /questions/{id}
     *
     * @param int $id
     * @param UpdateQuestionAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateQuestionAPIRequest $request)
    {
        $input = $request->all();

        /** @var Question $question */
        $question = $this->questionRepository->find($id);

        if (empty($question)) {
            return $this->sendError('Question not found');
        }

        $question = $this->questionRepository->update($input, $id);

        return $this->sendResponse($question->toArray(), 'Question updated successfully');
    }

    /**
     * Remove the specified Question from storage.
     * DELETE /questions/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Question $question */
        $question = $this->questionRepository->find($id);

        if (empty($question)) {
            return $this->sendError('Question not found');
        }

        $question->delete();

        return $this->sendResponse($id, 'Question deleted successfully');
    }
}

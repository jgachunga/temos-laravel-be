<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\API\V1\CreateQuestionTypeAPIRequest;
use App\Http\Requests\API\V1\UpdateQuestionTypeAPIRequest;
use App\Models\QuestionType;
use App\Repositories\Backend\QuestionTypeRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class QuestionTypeController
 * @package App\Http\Controllers\API\V1
 */

class QuestionTypeAPIController extends AppBaseController
{
    /** @var  QuestionTypeRepository */
    private $questionTypeRepository;

    public function __construct(QuestionTypeRepository $questionTypeRepo)
    {
        $this->questionTypeRepository = $questionTypeRepo;
    }

    /**
     * Display a listing of the QuestionType.
     * GET|HEAD /questionTypes
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $questionTypes = $this->questionTypeRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($questionTypes->toArray(), 'Question Types retrieved successfully');
    }

    /**
     * Store a newly created QuestionType in storage.
     * POST /questionTypes
     *
     * @param CreateQuestionTypeAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateQuestionTypeAPIRequest $request)
    {
        $input = $request->all();

        $questionType = $this->questionTypeRepository->create($input);

        return $this->sendResponse($questionType->toArray(), 'Question Type saved successfully');
    }

    /**
     * Display the specified QuestionType.
     * GET|HEAD /questionTypes/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var QuestionType $questionType */
        $questionType = $this->questionTypeRepository->find($id);

        if (empty($questionType)) {
            return $this->sendError('Question Type not found');
        }

        return $this->sendResponse($questionType->toArray(), 'Question Type retrieved successfully');
    }

    /**
     * Update the specified QuestionType in storage.
     * PUT/PATCH /questionTypes/{id}
     *
     * @param int $id
     * @param UpdateQuestionTypeAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateQuestionTypeAPIRequest $request)
    {
        $input = $request->all();

        /** @var QuestionType $questionType */
        $questionType = $this->questionTypeRepository->find($id);

        if (empty($questionType)) {
            return $this->sendError('Question Type not found');
        }

        $questionType = $this->questionTypeRepository->update($input, $id);

        return $this->sendResponse($questionType->toArray(), 'QuestionType updated successfully');
    }

    /**
     * Remove the specified QuestionType from storage.
     * DELETE /questionTypes/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var QuestionType $questionType */
        $questionType = $this->questionTypeRepository->find($id);

        if (empty($questionType)) {
            return $this->sendError('Question Type not found');
        }

        $questionType->delete();

        return $this->sendSuccess('Question Type deleted successfully');
    }
}

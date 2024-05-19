<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\API\V1\CreateQuestionImagesAPIRequest;
use App\Http\Requests\API\V1\UpdateQuestionImagesAPIRequest;
use App\Models\QuestionImages;
use App\Repositories\Backend\QuestionImagesRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class QuestionImagesController
 * @package App\Http\Controllers\API\V1
 */

class QuestionImagesAPIController extends AppBaseController
{
    /** @var  QuestionImagesRepository */
    private $questionImagesRepository;

    public function __construct(QuestionImagesRepository $questionImagesRepo)
    {
        $this->questionImagesRepository = $questionImagesRepo;
    }

    /**
     * Display a listing of the QuestionImages.
     * GET|HEAD /questionImages
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $questionImages = $this->questionImagesRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($questionImages->toArray(), 'Question Images retrieved successfully');
    }

    /**
     * Store a newly created QuestionImages in storage.
     * POST /questionImages
     *
     * @param CreateQuestionImagesAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateQuestionImagesAPIRequest $request)
    {
        $input = $request->all();

        $questionImages = $this->questionImagesRepository->create($input);

        return $this->sendResponse($questionImages->toArray(), 'Question Images saved successfully');
    }

    /**
     * Display the specified QuestionImages.
     * GET|HEAD /questionImages/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var QuestionImages $questionImages */
        $questionImages = $this->questionImagesRepository->find($id);

        if (empty($questionImages)) {
            return $this->sendError('Question Images not found');
        }

        return $this->sendResponse($questionImages->toArray(), 'Question Images retrieved successfully');
    }

    /**
     * Update the specified QuestionImages in storage.
     * PUT/PATCH /questionImages/{id}
     *
     * @param int $id
     * @param UpdateQuestionImagesAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateQuestionImagesAPIRequest $request)
    {
        $input = $request->all();

        /** @var QuestionImages $questionImages */
        $questionImages = $this->questionImagesRepository->find($id);

        if (empty($questionImages)) {
            return $this->sendError('Question Images not found');
        }

        $questionImages = $this->questionImagesRepository->update($input, $id);

        return $this->sendResponse($questionImages->toArray(), 'QuestionImages updated successfully');
    }

    /**
     * Remove the specified QuestionImages from storage.
     * DELETE /questionImages/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var QuestionImages $questionImages */
        $questionImages = $this->questionImagesRepository->find($id);

        if (empty($questionImages)) {
            return $this->sendError('Question Images not found');
        }

        $questionImages->delete();

        return $this->sendResponse($id, 'Question Images deleted successfully');
    }
}

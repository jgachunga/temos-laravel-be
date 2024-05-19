<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\API\V1\CreateFormsAnswersAPIRequest;
use App\Http\Requests\API\V1\UpdateFormsAnswersAPIRequest;
use App\Models\FormsAnswers;
use App\Repositories\Backend\FormsAnswersRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class FormsAnswersController
 * @package App\Http\Controllers\API\V1
 */

class FormsAnswersAPIController extends AppBaseController
{
    /** @var  FormsAnswersRepository */
    private $formsAnswersRepository;

    public function __construct(FormsAnswersRepository $formsAnswersRepo)
    {
        $this->formsAnswersRepository = $formsAnswersRepo;
    }

    /**
     * Display a listing of the FormsAnswers.
     * GET|HEAD /formsAnswers
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $formsAnswers = $this->formsAnswersRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($formsAnswers->toArray(), 'Forms Answers retrieved successfully');
    }

    /**
     * Store a newly created FormsAnswers in storage.
     * POST /formsAnswers
     *
     * @param CreateFormsAnswersAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateFormsAnswersAPIRequest $request)
    {
        $input = $request->all();

        $formsAnswers = $this->formsAnswersRepository->create($input);

        return $this->sendResponse($formsAnswers->toArray(), 'Forms Answers saved successfully');
    }

    /**
     * Display the specified FormsAnswers.
     * GET|HEAD /formsAnswers/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var FormsAnswers $formsAnswers */
        $formsAnswers = $this->formsAnswersRepository->find($id);

        if (empty($formsAnswers)) {
            return $this->sendError('Forms Answers not found');
        }

        return $this->sendResponse($formsAnswers->toArray(), 'Forms Answers retrieved successfully');
    }

    /**
     * Update the specified FormsAnswers in storage.
     * PUT/PATCH /formsAnswers/{id}
     *
     * @param int $id
     * @param UpdateFormsAnswersAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateFormsAnswersAPIRequest $request)
    {
        $input = $request->all();

        /** @var FormsAnswers $formsAnswers */
        $formsAnswers = $this->formsAnswersRepository->find($id);

        if (empty($formsAnswers)) {
            return $this->sendError('Forms Answers not found');
        }

        $formsAnswers = $this->formsAnswersRepository->update($input, $id);

        return $this->sendResponse($formsAnswers->toArray(), 'FormsAnswers updated successfully');
    }

    /**
     * Remove the specified FormsAnswers from storage.
     * DELETE /formsAnswers/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var FormsAnswers $formsAnswers */
        $formsAnswers = $this->formsAnswersRepository->find($id);

        if (empty($formsAnswers)) {
            return $this->sendError('Forms Answers not found');
        }

        $formsAnswers->delete();

        return $this->sendResponse($id, 'Forms Answers deleted successfully');
    }
}

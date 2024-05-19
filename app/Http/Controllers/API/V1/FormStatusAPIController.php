<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\API\V1\CreateFormStatusAPIRequest;
use App\Http\Requests\API\V1\UpdateFormStatusAPIRequest;
use App\Models\FormStatus;
use App\Repositories\Backend\FormStatusRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class FormStatusController
 * @package App\Http\Controllers\API\V1
 */

class FormStatusAPIController extends AppBaseController
{
    /** @var  FormStatusRepository */
    private $formStatusRepository;

    public function __construct(FormStatusRepository $formStatusRepo)
    {
        $this->formStatusRepository = $formStatusRepo;
    }

    /**
     * Display a listing of the FormStatus.
     * GET|HEAD /formStatuses
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $formStatuses = $this->formStatusRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($formStatuses->toArray(), 'Form Statuses retrieved successfully');
    }

    /**
     * Store a newly created FormStatus in storage.
     * POST /formStatuses
     *
     * @param CreateFormStatusAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateFormStatusAPIRequest $request)
    {
        $input = $request->all();

        $formStatus = $this->formStatusRepository->create($input);

        return $this->sendResponse($formStatus->toArray(), 'Form Status saved successfully');
    }

    /**
     * Display the specified FormStatus.
     * GET|HEAD /formStatuses/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var FormStatus $formStatus */
        $formStatus = $this->formStatusRepository->find($id);

        if (empty($formStatus)) {
            return $this->sendError('Form Status not found');
        }

        return $this->sendResponse($formStatus->toArray(), 'Form Status retrieved successfully');
    }

    /**
     * Update the specified FormStatus in storage.
     * PUT/PATCH /formStatuses/{id}
     *
     * @param int $id
     * @param UpdateFormStatusAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateFormStatusAPIRequest $request)
    {
        $input = $request->all();

        /** @var FormStatus $formStatus */
        $formStatus = $this->formStatusRepository->find($id);

        if (empty($formStatus)) {
            return $this->sendError('Form Status not found');
        }

        $formStatus = $this->formStatusRepository->update($input, $id);

        return $this->sendResponse($formStatus->toArray(), 'FormStatus updated successfully');
    }

    /**
     * Remove the specified FormStatus from storage.
     * DELETE /formStatuses/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var FormStatus $formStatus */
        $formStatus = $this->formStatusRepository->find($id);

        if (empty($formStatus)) {
            return $this->sendError('Form Status not found');
        }

        $formStatus->delete();

        return $this->sendResponse($id, 'Form Status deleted successfully');
    }
}

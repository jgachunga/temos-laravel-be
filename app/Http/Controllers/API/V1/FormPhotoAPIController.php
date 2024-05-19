<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\API\V1\CreateFormPhotoAPIRequest;
use App\Http\Requests\API\V1\UpdateFormPhotoAPIRequest;
use App\Models\FormPhoto;
use App\Repositories\Backend\FormPhotoRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\FormPhotoResource;
use Response;

/**
 * Class FormPhotoController
 * @package App\Http\Controllers\API\V1
 */

class FormPhotoAPIController extends AppBaseController
{
    /** @var  FormPhotoRepository */
    private $formPhotoRepository;

    public function __construct(FormPhotoRepository $formPhotoRepo)
    {
        $this->formPhotoRepository = $formPhotoRepo;
    }

    /**
     * Display a listing of the FormPhoto.
     * GET|HEAD /formPhotos
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $formPhotos = $this->formPhotoRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(FormPhotoResource::collection($formPhotos), 'Form Photos retrieved successfully');
    }

    /**
     * Store a newly created FormPhoto in storage.
     * POST /formPhotos
     *
     * @param CreateFormPhotoAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateFormPhotoAPIRequest $request)
    {
        $input = $request->all();

        $formPhoto = $this->formPhotoRepository->create($input);

        return $this->sendResponse(new FormPhotoResource($formPhoto), 'Form Photo saved successfully');
    }

    /**
     * Display the specified FormPhoto.
     * GET|HEAD /formPhotos/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var FormPhoto $formPhoto */
        $formPhoto = $this->formPhotoRepository->find($id);

        if (empty($formPhoto)) {
            return $this->sendError('Form Photo not found');
        }

        return $this->sendResponse(new FormPhotoResource($formPhoto), 'Form Photo retrieved successfully');
    }

    /**
     * Update the specified FormPhoto in storage.
     * PUT/PATCH /formPhotos/{id}
     *
     * @param int $id
     * @param UpdateFormPhotoAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateFormPhotoAPIRequest $request)
    {
        $input = $request->all();

        /** @var FormPhoto $formPhoto */
        $formPhoto = $this->formPhotoRepository->find($id);

        if (empty($formPhoto)) {
            return $this->sendError('Form Photo not found');
        }

        $formPhoto = $this->formPhotoRepository->update($input, $id);

        return $this->sendResponse(new FormPhotoResource($formPhoto), 'FormPhoto updated successfully');
    }

    /**
     * Remove the specified FormPhoto from storage.
     * DELETE /formPhotos/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var FormPhoto $formPhoto */
        $formPhoto = $this->formPhotoRepository->find($id);

        if (empty($formPhoto)) {
            return $this->sendError('Form Photo not found');
        }

        $formPhoto->delete();

        return $this->sendSuccess('Form Photo deleted successfully');
    }
}

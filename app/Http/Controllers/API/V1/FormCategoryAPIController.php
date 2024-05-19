<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\API\V1\CreateFormCategoryAPIRequest;
use App\Http\Requests\API\V1\UpdateFormCategoryAPIRequest;
use App\Models\FormCategory;
use App\Repositories\Backend\FormCategoryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class FormCategoryController
 * @package App\Http\Controllers\API\V1
 */

class FormCategoryAPIController extends AppBaseController
{
    /** @var  FormCategoryRepository */
    private $formCategoryRepository;

    public function __construct(FormCategoryRepository $formCategoryRepo)
    {
        $this->formCategoryRepository = $formCategoryRepo;
    }

    /**
     * Display a listing of the FormCategory.
     * GET|HEAD /formCategories
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $page = $request->only('page');
        $structures = $request->get('structures');
        if(isset($page)&&!empty($page)){
            $formCategories = FormCategory::whereIn('structure_id', $structures)->orderByDesc('created_at')->paginate(5);
        }else{
            $formCategories = FormCategory::whereIn('structure_id', $structures)->orderByDesc('created_at')->get()->toArray();
        }

        return $this->sendResponse($formCategories, 'Form Categories retrieved successfully');
    }

    /**
     * Store a newly created FormCategory in storage.
     * POST /formCategories
     *
     * @param CreateFormCategoryAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateFormCategoryAPIRequest $request)
    {
        $input = $request->all();

        $formCategory = $this->formCategoryRepository->create($input);

        return $this->sendResponse($formCategory->toArray(), 'Form Category saved successfully');
    }

    /**
     * Display the specified FormCategory.
     * GET|HEAD /formCategories/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var FormCategory $formCategory */
        $formCategory = $this->formCategoryRepository->find($id);

        if (empty($formCategory)) {
            return $this->sendError('Form Category not found');
        }

        return $this->sendResponse($formCategory->toArray(), 'Form Category retrieved successfully');
    }

    /**
     * Update the specified FormCategory in storage.
     * PUT/PATCH /formCategories/{id}
     *
     * @param int $id
     * @param UpdateFormCategoryAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateFormCategoryAPIRequest $request)
    {
        $input = $request->all();

        /** @var FormCategory $formCategory */
        $formCategory = $this->formCategoryRepository->find($id);

        if (empty($formCategory)) {
            return $this->sendError('Form Category not found');
        }

        $formCategory = $this->formCategoryRepository->update($input, $id);

        return $this->sendResponse($formCategory->toArray(), 'FormCategory updated successfully');
    }
    public function updateStatus($id, Request $request)
    {
        $input = $request->all();
        \Log::debug($input);
        /** @var FormCategory $formCategory */
        $formCategory = $this->formCategoryRepository->find($id);

        if (empty($formCategory)) {
            return $this->sendError('Form Category not found');
        }

        $formCategory = $this->formCategoryRepository->updateStatus($input, $id);

        return $this->sendResponse($formCategory->toArray(), 'FormCategory updated successfully');
    }

    /**
     * Remove the specified FormCategory from storage.
     * DELETE /formCategories/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var FormCategory $formCategory */
        $formCategory = $this->formCategoryRepository->find($id);

        if (empty($formCategory)) {
            return $this->sendError('Form Category not found');
        }

        $formCategory->delete();

        return $this->sendResponse($id, 'Form Category deleted successfully');
    }
}

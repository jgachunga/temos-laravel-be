<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\API\V1\CreateFormAPIRequest;
use App\Http\Requests\API\V1\UpdateFormAPIRequest;
use App\Models\Form;
use App\Repositories\Backend\FormRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\FormCategoryResource;
use App\Http\Resources\FormResource;
use App\Models\FormCategory;
use Response;

/**
 * Class FormController
 * @package App\Http\Controllers\API\V1
 */

class FormAPIController extends AppBaseController
{
    /** @var  FormRepository */
    private $formRepository;

    public function __construct(FormRepository $formRepo)
    {
        $this->formRepository = $formRepo;
    }

    /**
     * Display a listing of the Form.
     * GET|HEAD /forms
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $structures = $request->get('structures');
        $forms = Form::whereIn('structure_id', $structures)->orderByDesc('created_at')->paginate(5);

        return $this->sendResponse($forms, 'Forms retrieved successfully');
    }

    public function indexapp(Request $request)
    {
        $structures = $request->get('structures');
        $category_id = $request->get('category_id');
        $forms = Form::whereIn('structure_id', $structures)->where('form_category_id', $category_id)->orderByDesc('created_at')->get();

        return $this->sendResponse($forms->toArray(), 'Forms retrieved successfully');
    }
    public function indexcustom(Request $request)
    {
        $structures = $request->get('structures');
        $category_id = $request->get('category_id');

        $forms = Form::whereIn('structure_id', $structures)
        ->where('form_category_id', $category_id)
        ->where('id', 12)
        ->with('questions', 'questions.options', 'questions.skip_conditions', 'questions.skip_conditions.questionselected', 'questions.skip_conditions.option')
        ->orderByDesc('created_at')->get();

        return $this->sendResponse($forms->toArray(), 'Forms retrieved successfully');
    }

    public function formAll(Request $request){
        $structures = $request->get('structures');

        $forms = Form::whereIn('structure_id', $structures)
        ->with('questions', 'questions.options', 'questions.skip_conditions', 'questions.skip_conditions.questionselected', 'questions.skip_conditions.option')
        ->orderByDesc('created_at')->get();

        return $this->sendResponse(FormResource::collection($forms), 'Forms retrieved successfully');
    }

    /**
     * Store a newly created Form in storage.
     * POST /forms
     *
     * @param CreateFormAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateFormAPIRequest $request)
    {
        $input = $request->all();

        $form = $this->formRepository->create($input);

        return $this->sendResponse($form->toArray(), 'Form saved successfully');
    }
    public function storeCustom(CreateFormAPIRequest $request)
    {
        $input = $request->all();

        $form = $this->formRepository->createCustom($input);

        return $this->sendResponse($form->toArray(), 'Form saved successfully');
    }

    public function storeApi(CreateFormAPIRequest $request)
    {
        $input = $request->all();
        $uploadedFiles = $request->allFiles();
        $form = $this->formRepository->createApi($input, $uploadedFiles);

        return $this->sendResponse($form->toArray(), 'Form saved successfully');
    }

    /**
     * Display the specified Form.
     * GET|HEAD /forms/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Form $form */
        $form = $this->formRepository->find($id);

        if (empty($form)) {
            return $this->sendError('Form not found');
        }

        return $this->sendResponse($form->toArray(), 'Form retrieved successfully');
    }

    /**
     * Update the specified Form in storage.
     * PUT/PATCH /forms/{id}
     *
     * @param int $id
     * @param UpdateFormAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateFormAPIRequest $request)
    {
        $input = $request->all();

        /** @var Form $form */
        $form = $this->formRepository->find($id);

        if (empty($form)) {
            return $this->sendError('Form not found');
        }

        $form = $this->formRepository->update($input, $id);

        return $this->sendResponse($form->toArray(), 'Form updated successfully');
    }

    /**
     * Remove the specified Form from storage.
     * DELETE /forms/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Form $form */
        $form = $this->formRepository->find($id);

        if (empty($form)) {
            return $this->sendError('Form not found');
        }

        $form->delete();

        return $this->sendResponse($id, 'Form deleted successfully');
    }
}

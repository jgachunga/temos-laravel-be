<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\API\V1\CreateCategoryAPIRequest;
use App\Http\Requests\API\V1\UpdateCategoryAPIRequest;
use App\Models\Category;
use App\Repositories\Backend\CategoryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class CategoryController
 * @package App\Http\Controllers\API\V1
 */

class CategoryAPIController extends AppBaseController
{
    /** @var  CategoryRepository */
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepo)
    {
        $this->categoryRepository = $categoryRepo;
    }

    /**
     * Display a listing of the Category.
     * GET|HEAD /categories
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $page = $request->only('page');
        if(isset($page)&&!empty($page)){
            $categories = Category::orderByDesc('created_at')->paginate(5);
        }else{
            $categories = $this->categoryRepository->all(
                $request->except(['skip', 'limit']),
                $request->get('skip'),
                $request->get('limit')
            );
        }
        return $this->sendResponse($categories->toArray(), 'Categories retrieved successfully');
    }

    /**
     * Store a newly created Category in storage.
     * POST /categories
     *
     * @param CreateCategoryAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateCategoryAPIRequest $request)
    {
        $input=$request->json()->all();

        $category = $this->categoryRepository->create($input);

        return $this->sendResponse($category->toArray(), 'Category saved successfully');
    }

    /**
     * Display the specified Category.
     * GET|HEAD /categories/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Category $category */
        $category = $this->categoryRepository->find($id);

        if (empty($category)) {
            return $this->sendError('Category not found');
        }

        return $this->sendResponse($category->toArray(), 'Category retrieved successfully');
    }

    /**
     * Update the specified Category in storage.
     * PUT/PATCH /categories/{id}
     *
     * @param int $id
     * @param UpdateCategoryAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCategoryAPIRequest $request)
    {
        $input = $request->all();

        /** @var Category $category */
        $category = $this->categoryRepository->find($id);

        if (empty($category)) {
            return $this->sendError('Category not found');
        }

        $category = $this->categoryRepository->update($input, $id);

        return $this->sendResponse($category->toArray(), 'Category updated successfully');
    }

    /**
     * Remove the specified Category from storage.
     * DELETE /categories/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Category $category */
        $category = $this->categoryRepository->find($id);

        if (empty($category)) {
            return $this->sendError('Category not found');
        }

        $category->delete();

        return $this->sendResponse($id, 'Category deleted successfully');
    }
}

<?php

namespace App\Http\Controllers\API\V1;

use App\Exceptions\GeneralException;
use App\Http\Requests\API\V1\CreateProductAPIRequest;
use App\Http\Requests\API\V1\UpdateProductAPIRequest;
use App\Models\Product;
use App\Repositories\Backend\ProductRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Log;
use Response;
use App\Helpers\StructureHelper;
use App\Http\Resources\ProductResource;
use App\Imports\ProductsImport;
use Excel;
use Illuminate\Support\Facades\Auth;
use Storage;

/**
 * Class ProductController
 * @package App\Http\Controllers\API\V1
 */

class ProductAPIController extends AppBaseController
{
    /** @var  ProductRepository */
    private $productRepository;
    private $structureHelper;

    public function __construct(ProductRepository $productRepo, StructureHelper $structureHelper)
    {
        $this->productRepository = $productRepo;
        $this->structureHelper = $structureHelper;
    }

    /**
     * Display a listing of the Product.
     * GET|HEAD /products
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $products = Product::with('prices')->orderByDesc('created_at')->get();

        return $this->sendResponse(ProductResource::collection($products), 'Products retrieved successfully');
    }
    public function serverSideApi()
    {
        $structure_id = Auth::guard('api')->user()->structure_id;
        $structure_ids = $this->structureHelper->getChildren($structure_id);

        $products = Product::whereIn('structure_id', $structure_ids)->with('prices')->orderByDesc('created_at')->get();

        return $this->sendResponse($products->toArray(), 'Products retrieved successfully');
    }
    public function serverSide(Request $request)
    {
        $products = Product::with('prices', 'prices.channel')->orderByDesc('created_at')->paginate(5);

        return $this->sendResponse($products->toArray(), 'Products retrieved successfully');
    }
    /**
     * Store a newly created Product in storage.
     * POST /products
     *
     * @param CreateProductAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateProductAPIRequest $request)
    {
        $input = $request->all();
        Log::debug($input);
        $destinationPath = storage_path('/app/public');
        if ($request->hasFile("product_image")){
            $productimage=$request->file('product_image');
            $_productimage = rand().'.'.$productimage->getClientOriginalExtension();
            $productimage->move($destinationPath, $_productimage);
            }
        if(isset($_productimage)){
            $input['img_url'] = $_productimage;
        }
        $product = $this->productRepository->create($input);

        return $this->sendResponse($product->toArray(), 'Product saved successfully');
    }

    /**
     * Display the specified Product.
     * GET|HEAD /products/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Product $product */
        $product = $this->productRepository->find($id);

        if (empty($product)) {
            return $this->sendError('Product not found');
        }

        return $this->sendResponse($product->toArray(), 'Product retrieved successfully');
    }

    /**
     * Update the specified Product in storage.
     * PUT/PATCH /products/{id}
     *
     * @param int $id
     * @param UpdateProductAPIRequest $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $input = $request->all();
        Log::debug($input);
        /** @var Product $product */
        $product = $this->productRepository->find($id);

        if (empty($product)) {
            return $this->sendError('Product not found');
        }
        Log::debug($input);
        $product = $this->productRepository->update($input, $id);

        return $this->sendResponse($product->toArray(), 'Product updated successfully');
    }

    /**
     * Remove the specified Product from storage.
     * DELETE /products/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Product $product */
        $product = $this->productRepository->find($id);

        if (empty($product)) {
            return $this->sendError('Product not found');
        }

        $product->delete();

        return $this->sendResponse($id, 'Product deleted successfully');
    }
    public function downloadTemplate(){
        $headers = [
            'Content-Type' => 'application/xlsx',
        ];
        $filename = 'templates/Product_Template.xlsx';
        return response()->download(storage_path('app/public/' . $filename), 'filename.pdf', $headers);
    }
    public function importExcel(){
        if(!request()->hasFile('product_excel')){
            throw new \Exception("File is required");
        }
        $file = request()->file('product_excel');
        Excel::import(new ProductsImport(), $file);
        return $this->sendResponse([], 'Upload completed successfully');
    }
}

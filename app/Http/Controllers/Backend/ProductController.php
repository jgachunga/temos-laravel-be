<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\ProductDataTable;
use App\Http\Requests\Backend;
use App\Http\Requests\Backend\CreateProductRequest;
use Illuminate\Http\Request;
use App\Http\Requests\Backend\UpdateProductRequest;
use App\Repositories\Backend\ProductRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\Category;
use App\Models\Client;
use App\Imports\ProductsImport;
use Excel;
use Exception;

class ProductController extends AppBaseController
{
    /** @var  ProductRepository */
    private $productRepository;

    public function __construct(ProductRepository $productRepo)
    {
        $this->productRepository = $productRepo;
    }

    /**
     * Display a listing of the Product.
     *
     * @param ProductDataTable $productDataTable
     * @return Response
     */
    public function index(ProductDataTable $productDataTable)
    {
        return $productDataTable->render('backend.products.index');
    }

    /**
     * Show the form for creating a new Product.
     *
     * @return Response
     */
    public function create()
    {
        $categories = Category::orderBy('id', 'DESC')->pluck('name', 'id');
        $clients = Client::orderBy('id', 'DESC')->pluck('name', 'id');
        return view('backend.products.create')->with(compact('categories', 'clients'));
    }
        /**
     * Show the form for creating a new Product.
     *
     * @return Response
     */
    public function createMultiple()
    {
        $categories = Category::orderBy('id', 'DESC')->pluck('name', 'id');
        $clients = Client::orderBy('id', 'DESC')->pluck('name', 'id');
        return view('backend.products.create_multiple')->with(compact('categories', 'clients'));
    }

    /**
     * Store a newly created Product in storage.
     *
     * @param CreateProductRequest $request
     *
     * @return Response
     */
    public function store(CreateProductRequest $request)
    {
        $input = $request->all();

        $product = $this->productRepository->create($input);

        Flash::success('Product saved successfully.');

        return redirect(route('admin.products.index'));
    }

    /**
     * Store a newly created Product in storage.
     *
     * @param CreateProductRequest $request
     *
     * @return Response
     */
    public function storeUpload(Request $request)
    {
        $input = $request->all();
        // try{
            $cliet_id = $input['client_id'];
            Excel::import(new ProductsImport($cliet_id), request()->file('productfile'));
            Flash::success('Products saved successfully.');

            return redirect(route('admin.products.index'));
        // }catch(Exception $e){
        //     dd($e);
        //     Flash::success('Products saved successfully.');

        //     return back()->with('success', 'An error occurred.');
        // }
        
    }
    /**
     * Display the specified Product.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $product = $this->productRepository->find($id);

        if (empty($product)) {
            Flash::error('Product not found');

            return redirect(route('admin.products.index'));
        }

        return view('backend.products.show')->with('product', $product);
    }

    /**
     * Show the form for editing the specified Product.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $product = $this->productRepository->find($id);
        
        if (empty($product)) {
            Flash::error('Product not found');

            return redirect(route('admin.products.index'));
        }
        $categories = Category::orderBy('id', 'DESC')->pluck('name', 'id');
        $clients = Client::orderBy('id', 'DESC')->pluck('name', 'id');
        return view('backend.products.edit')->with(compact('product', 'categories', 'clients'));
    }

    /**
     * Update the specified Product in storage.
     *
     * @param  int              $id
     * @param UpdateProductRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateProductRequest $request)
    {
        $product = $this->productRepository->find($id);

        if (empty($product)) {
            Flash::error('Product not found');

            return redirect(route('admin.products.index'));
        }

        $product = $this->productRepository->update($request->all(), $id);

        Flash::success('Product updated successfully.');

        return redirect(route('admin.products.index'));
    }

    /**
     * Remove the specified Product from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $product = $this->productRepository->find($id);

        if (empty($product)) {
            Flash::error('Product not found');

            return redirect(route('admin.products.index'));
        }

        $this->productRepository->delete($id);

        Flash::success('Product deleted successfully.');

        return redirect(route('admin.products.index'));
    }
    public function getDownload(){
        $pathToFile=storage_path()."/templates/templateitems.xlsx";
        return response()->download($pathToFile);
    }
}

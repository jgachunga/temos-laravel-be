<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\SaleStructureDataTable;
use App\Http\Requests\Backend;
use App\Http\Requests\Backend\CreateSaleStructureRequest;
use App\Http\Requests\Backend\UpdateSaleStructureRequest;
use App\Repositories\Backend\SaleStructureRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class SaleStructureController extends AppBaseController
{
    /** @var  SaleStructureRepository */
    private $saleStructureRepository;

    public function __construct(SaleStructureRepository $saleStructureRepo)
    {
        $this->saleStructureRepository = $saleStructureRepo;
    }

    /**
     * Display a listing of the SaleStructure.
     *
     * @param SaleStructureDataTable $saleStructureDataTable
     * @return Response
     */
    public function index(SaleStructureDataTable $saleStructureDataTable)
    {
        return $saleStructureDataTable->render('sale_structures.index');
    }

    /**
     * Show the form for creating a new SaleStructure.
     *
     * @return Response
     */
    public function create()
    {
        return view('sale_structures.create');
    }

    /**
     * Store a newly created SaleStructure in storage.
     *
     * @param CreateSaleStructureRequest $request
     *
     * @return Response
     */
    public function store(CreateSaleStructureRequest $request)
    {
        $input = $request->all();

        $saleStructure = $this->saleStructureRepository->create($input);

        Flash::success('Sale Structure saved successfully.');

        return redirect(route('saleStructures.index'));
    }

    /**
     * Display the specified SaleStructure.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $saleStructure = $this->saleStructureRepository->find($id);

        if (empty($saleStructure)) {
            Flash::error('Sale Structure not found');

            return redirect(route('saleStructures.index'));
        }

        return view('sale_structures.show')->with('saleStructure', $saleStructure);
    }

    /**
     * Show the form for editing the specified SaleStructure.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $saleStructure = $this->saleStructureRepository->find($id);

        if (empty($saleStructure)) {
            Flash::error('Sale Structure not found');

            return redirect(route('saleStructures.index'));
        }

        return view('sale_structures.edit')->with('saleStructure', $saleStructure);
    }

    /**
     * Update the specified SaleStructure in storage.
     *
     * @param  int              $id
     * @param UpdateSaleStructureRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSaleStructureRequest $request)
    {
        $saleStructure = $this->saleStructureRepository->find($id);

        if (empty($saleStructure)) {
            Flash::error('Sale Structure not found');

            return redirect(route('saleStructures.index'));
        }

        $saleStructure = $this->saleStructureRepository->update($request->all(), $id);

        Flash::success('Sale Structure updated successfully.');

        return redirect(route('saleStructures.index'));
    }

    /**
     * Remove the specified SaleStructure from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $saleStructure = $this->saleStructureRepository->find($id);

        if (empty($saleStructure)) {
            Flash::error('Sale Structure not found');

            return redirect(route('saleStructures.index'));
        }

        $this->saleStructureRepository->delete($id);

        Flash::success('Sale Structure deleted successfully.');

        return redirect(route('saleStructures.index'));
    }
}

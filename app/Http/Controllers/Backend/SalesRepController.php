<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\SalesRepDataTable;
use App\Http\Requests\Backend;
use App\Http\Requests\Backend\CreateSalesRepRequest;
use App\Http\Requests\Backend\UpdateSalesRepRequest;
use App\Repositories\Backend\SalesRepRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class SalesRepController extends AppBaseController
{
    /** @var  SalesRepRepository */
    private $salesRepRepository;

    public function __construct(SalesRepRepository $salesRepRepo)
    {
        $this->salesRepRepository = $salesRepRepo;
    }

    /**
     * Display a listing of the SalesRep.
     *
     * @param SalesRepDataTable $salesRepDataTable
     * @return Response
     */
    public function index(SalesRepDataTable $salesRepDataTable)
    {
        return $salesRepDataTable->render('sales_reps.index');
    }

    /**
     * Show the form for creating a new SalesRep.
     *
     * @return Response
     */
    public function create()
    {
        return view('sales_reps.create');
    }

    /**
     * Store a newly created SalesRep in storage.
     *
     * @param CreateSalesRepRequest $request
     *
     * @return Response
     */
    public function store(CreateSalesRepRequest $request)
    {
        $input = $request->all();

        $salesRep = $this->salesRepRepository->create($input);

        Flash::success('Sales Rep saved successfully.');

        return redirect(route('salesReps.index'));
    }

    /**
     * Display the specified SalesRep.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $salesRep = $this->salesRepRepository->find($id);

        if (empty($salesRep)) {
            Flash::error('Sales Rep not found');

            return redirect(route('salesReps.index'));
        }

        return view('sales_reps.show')->with('salesRep', $salesRep);
    }

    /**
     * Show the form for editing the specified SalesRep.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $salesRep = $this->salesRepRepository->find($id);

        if (empty($salesRep)) {
            Flash::error('Sales Rep not found');

            return redirect(route('salesReps.index'));
        }

        return view('sales_reps.edit')->with('salesRep', $salesRep);
    }

    /**
     * Update the specified SalesRep in storage.
     *
     * @param  int              $id
     * @param UpdateSalesRepRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSalesRepRequest $request)
    {
        $salesRep = $this->salesRepRepository->find($id);

        if (empty($salesRep)) {
            Flash::error('Sales Rep not found');

            return redirect(route('salesReps.index'));
        }

        $salesRep = $this->salesRepRepository->update($request->all(), $id);

        Flash::success('Sales Rep updated successfully.');

        return redirect(route('salesReps.index'));
    }

    /**
     * Remove the specified SalesRep from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $salesRep = $this->salesRepRepository->find($id);

        if (empty($salesRep)) {
            Flash::error('Sales Rep not found');

            return redirect(route('salesReps.index'));
        }

        $this->salesRepRepository->delete($id);

        Flash::success('Sales Rep deleted successfully.');

        return redirect(route('salesReps.index'));
    }
}

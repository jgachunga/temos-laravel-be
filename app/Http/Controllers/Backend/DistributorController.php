<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\DistributorDataTable;
use App\Http\Requests\Backend;
use App\Http\Requests\Backend\CreateDistributorRequest;
use App\Http\Requests\Backend\UpdateDistributorRequest;
use App\Repositories\Backend\DistributorRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\Auth\User;

class DistributorController extends AppBaseController
{
    /** @var  DistributorRepository */
    private $distributorRepository;

    public function __construct(DistributorRepository $distributorRepo)
    {
        $this->distributorRepository = $distributorRepo;
    }

    /**
     * Display a listing of the Distributor.
     *
     * @param DistributorDataTable $distributorDataTable
     * @return Response
     */
    public function index(DistributorDataTable $distributorDataTable)
    {
        return $distributorDataTable->render('backend.distributors.index');
    }

    /**
     * Show the form for creating a new Distributor.
     *
     * @return Response
     */
    public function create()
    {   
        $users = User::orderBy('id', 'DESC')->pluck('first_name', 'id');
        return view('backend.distributors.create')->with(compact('users'));
    }

    /**
     * Store a newly created Distributor in storage.
     *
     * @param CreateDistributorRequest $request
     *
     * @return Response
     */
    public function store(CreateDistributorRequest $request)
    {
        $input = $request->all();

        $distributor = $this->distributorRepository->create($input);

        Flash::success('Distributor saved successfully.');

        return redirect(route('admin.distributors.index'));
    }

    /**
     * Display the specified Distributor.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $distributor = $this->distributorRepository->find($id);

        if (empty($distributor)) {
            Flash::error('Distributor not found');

            return redirect(route('admin.distributors.index'));
        }

        return view('backend.distributors.show')->with('distributor', $distributor);
    }

    /**
     * Show the form for editing the specified Distributor.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $distributor = $this->distributorRepository->find($id);

        if (empty($distributor)) {
            Flash::error('Distributor not found');

            return redirect(route('admin.distributors.index'));
        }

        return view('backend.distributors.edit')->with('distributor', $distributor);
    }

    /**
     * Update the specified Distributor in storage.
     *
     * @param  int              $id
     * @param UpdateDistributorRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDistributorRequest $request)
    {
        $distributor = $this->distributorRepository->find($id);

        if (empty($distributor)) {
            Flash::error('Distributor not found');

            return redirect(route('admin.distributors.index'));
        }

        $distributor = $this->distributorRepository->update($request->all(), $id);

        Flash::success('Distributor updated successfully.');

        return redirect(route('admin.distributors.index'));
    }

    /**
     * Remove the specified Distributor from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $distributor = $this->distributorRepository->find($id);

        if (empty($distributor)) {
            Flash::error('Distributor not found');

            return redirect(route('admin.distributors.index'));
        }

        $this->distributorRepository->delete($id);

        Flash::success('Distributor deleted successfully.');

        return redirect(route('admin.distributors.index'));
    }
}

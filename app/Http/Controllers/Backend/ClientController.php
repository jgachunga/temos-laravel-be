<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\ClientDataTable;
use App\Http\Requests\Backend;
use App\Http\Requests\Backend\CreateClientRequest;
use App\Http\Requests\Backend\UpdateClientRequest;
use App\Repositories\Backend\ClientRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\Auth\User;

class ClientController extends AppBaseController
{
    /** @var  ClientRepository */
    private $clientRepository;

    public function __construct(ClientRepository $clientRepo)
    {
        $this->clientRepository = $clientRepo;
    }

    /**
     * Display a listing of the Client.
     *
     * @param ClientDataTable $clientDataTable
     * @return Response
     */
    public function index(ClientDataTable $clientDataTable)
    {
        return $clientDataTable->render('backend.clients.index');
    }

    /**
     * Show the form for creating a new Client.
     *
     * @return Response
     */
    public function create()
    {
        $users = User::orderBy('id', 'DESC')->pluck('first_name', 'id');
        return view('backend.clients.create')->with(compact('users'));
    }

    /**
     * Store a newly created Client in storage.
     *
     * @param CreateClientRequest $request
     *
     * @return Response
     */
    public function store(CreateClientRequest $request)
    {
        $input = $request->all();

        $client = $this->clientRepository->create($input);

        Flash::success('Client saved successfully.');

        return redirect(route('admin.clients.index'));
    }

    /**
     * Display the specified Client.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $client = $this->clientRepository->find($id);

        if (empty($client)) {
            Flash::error('Client not found');

            return redirect(route('admin.clients.index'));
        }

        return view('backend.clients.show')->with('client', $client);
    }

    /**
     * Show the form for editing the specified Client.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $client = $this->clientRepository->find($id);

        if (empty($client)) {
            Flash::error('Client not found');

            return redirect(route('clients.index'));
        }

        return view('backend.clients.edit')->with('client', $client);
    }

    /**
     * Update the specified Client in storage.
     *
     * @param  int              $id
     * @param UpdateClientRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateClientRequest $request)
    {
        $client = $this->clientRepository->find($id);

        if (empty($client)) {
            Flash::error('Client not found');

            return redirect(route('clients.index'));
        }

        $client = $this->clientRepository->update($request->all(), $id);

        Flash::success('Client updated successfully.');

        return redirect(route('clients.index'));
    }

    /**
     * Remove the specified Client from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $client = $this->clientRepository->find($id);

        if (empty($client)) {
            Flash::error('Client not found');

            return redirect(route('clients.index'));
        }

        $this->clientRepository->delete($id);

        Flash::success('Client deleted successfully.');

        return redirect(route('clients.index'));
    }
}

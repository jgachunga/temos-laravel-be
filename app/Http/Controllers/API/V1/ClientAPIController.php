<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\API\V1\CreateClientAPIRequest;
use App\Http\Requests\API\V1\UpdateClientAPIRequest;
use App\Models\Client;
use App\Repositories\Backend\ClientRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class ClientController
 * @package App\Http\Controllers\API\V1
 */

class ClientAPIController extends AppBaseController
{
    /** @var  ClientRepository */
    private $clientRepository;

    public function __construct(ClientRepository $clientRepo)
    {
        $this->clientRepository = $clientRepo;
    }

    /**
     * Display a listing of the Client.
     * GET|HEAD /clients
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $clients = $this->clientRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($clients->toArray(), 'Clients retrieved successfully');
    }

    /**
     * Store a newly created Client in storage.
     * POST /clients
     *
     * @param CreateClientAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateClientAPIRequest $request)
    {
        $input = $request->all();

        $client = $this->clientRepository->create($input);

        return $this->sendResponse($client->toArray(), 'Client saved successfully');
    }

    /**
     * Display the specified Client.
     * GET|HEAD /clients/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Client $client */
        $client = $this->clientRepository->find($id);

        if (empty($client)) {
            return $this->sendError('Client not found');
        }

        return $this->sendResponse($client->toArray(), 'Client retrieved successfully');
    }

    /**
     * Update the specified Client in storage.
     * PUT/PATCH /clients/{id}
     *
     * @param int $id
     * @param UpdateClientAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateClientAPIRequest $request)
    {
        $input = $request->all();

        /** @var Client $client */
        $client = $this->clientRepository->find($id);

        if (empty($client)) {
            return $this->sendError('Client not found');
        }

        $client = $this->clientRepository->update($input, $id);

        return $this->sendResponse($client->toArray(), 'Client updated successfully');
    }

    /**
     * Remove the specified Client from storage.
     * DELETE /clients/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Client $client */
        $client = $this->clientRepository->find($id);

        if (empty($client)) {
            return $this->sendError('Client not found');
        }

        $client->delete();

        return $this->sendResponse($id, 'Client deleted successfully');
    }
}

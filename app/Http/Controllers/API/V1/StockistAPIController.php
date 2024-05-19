<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\API\V1\CreateStockistAPIRequest;
use App\Http\Requests\API\V1\UpdateStockistAPIRequest;
use App\Models\Stockist;
use App\Repositories\Backend\StockistRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class StockistController
 * @package App\Http\Controllers\API\V1
 */

class StockistAPIController extends AppBaseController
{
    /** @var  StockistRepository */
    private $stockistRepository;

    public function __construct(StockistRepository $stockistRepo)
    {
        $this->stockistRepository = $stockistRepo;
    }

    /**
     * Display a listing of the Stockist.
     * GET|HEAD /stockists
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $page = $request->only('page');
        if(isset($page)&&!empty($page)){
            $stockists = Stockist::with('area')->orderByDesc('created_at')->paginate(5);
        }else{
            $stockists = $this->stockistRepository->all(
                $request->except(['skip', 'limit']),
                $request->get('skip'),
                $request->get('limit')
            );
        }

        return $this->sendResponse($stockists, 'Stockists retrieved successfully');
    }
    public function stockistByRoute($route_id)
    {
        $stockists = $this->stockistRepository->getbyRouteId($route_id);

        return $this->sendResponse($stockists->toArray(), 'Stockists retrieved successfully');
    }
    /**
     * Store a newly created Stockist in storage.
     * POST /stockists
     *
     * @param CreateStockistAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateStockistAPIRequest $request)
    {
        $input = $request->all();

        $stockist = $this->stockistRepository->create($input);

        return $this->sendResponse($stockist->toArray(), 'Stockist saved successfully');
    }

    /**
     * Display the specified Stockist.
     * GET|HEAD /stockists/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Stockist $stockist */
        $stockist = $this->stockistRepository->find($id);

        if (empty($stockist)) {
            return $this->sendError('Stockist not found');
        }

        return $this->sendResponse($stockist->toArray(), 'Stockist retrieved successfully');
    }

    /**
     * Update the specified Stockist in storage.
     * PUT/PATCH /stockists/{id}
     *
     * @param int $id
     * @param UpdateStockistAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateStockistAPIRequest $request)
    {
        $input = $request->all();

        /** @var Stockist $stockist */
        $stockist = $this->stockistRepository->find($id);

        if (empty($stockist)) {
            return $this->sendError('Stockist not found');
        }

        $stockist = $this->stockistRepository->update($input, $id);

        return $this->sendResponse($stockist->toArray(), 'Stockist updated successfully');
    }

    /**
     * Remove the specified Stockist from storage.
     * DELETE /stockists/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Stockist $stockist */
        $stockist = $this->stockistRepository->find($id);

        if (empty($stockist)) {
            return $this->sendError('Stockist not found');
        }

        $stockist->delete();

        return $this->sendResponse($id, 'Stockist deleted successfully');
    }
}

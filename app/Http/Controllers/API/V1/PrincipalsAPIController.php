<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\API\V1\CreatePrincipalsAPIRequest;
use App\Http\Requests\API\V1\UpdatePrincipalsAPIRequest;
use App\Models\Principals;
use App\Repositories\Backend\PrincipalsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class PrincipalsController
 * @package App\Http\Controllers\API\V1
 */

class PrincipalsAPIController extends AppBaseController
{
    /** @var  PrincipalsRepository */
    private $principalsRepository;

    public function __construct(PrincipalsRepository $principalsRepo)
    {
        $this->principalsRepository = $principalsRepo;
    }

    /**
     * Display a listing of the Principals.
     * GET|HEAD /principals
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $page = $request->only('page');
        if(isset($page)&&!empty($page)){
            $principals = Principals::orderByDesc('created_at')->paginate(5);
        }else{
            $principals = $this->principalsRepository->where('guard_name', 'api')->all(
                $request->except(['skip', 'limit']),
                $request->get('skip'),
                $request->get('limit')
            );
        }

        return $this->sendResponse($principals, 'Principals retrieved successfully');
    }

    /**
     * Store a newly created Principals in storage.
     * POST /principals
     *
     * @param CreatePrincipalsAPIRequest $request
     *
     * @return Response
     */
    public function store(CreatePrincipalsAPIRequest $request)
    {
        $input = $request->all();

        $principals = $this->principalsRepository->create($input);

        return $this->sendResponse($principals->toArray(), 'Principals saved successfully');
    }

    /**
     * Display the specified Principals.
     * GET|HEAD /principals/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Principals $principals */
        $principals = $this->principalsRepository->find($id);

        if (empty($principals)) {
            return $this->sendError('Principals not found');
        }

        return $this->sendResponse($principals->toArray(), 'Principals retrieved successfully');
    }

    /**
     * Update the specified Principals in storage.
     * PUT/PATCH /principals/{id}
     *
     * @param int $id
     * @param UpdatePrincipalsAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePrincipalsAPIRequest $request)
    {
        $input = $request->all();

        /** @var Principals $principals */
        $principals = $this->principalsRepository->find($id);

        if (empty($principals)) {
            return $this->sendError('Principals not found');
        }

        $principals = $this->principalsRepository->update($input, $id);

        return $this->sendResponse($principals->toArray(), 'Principals updated successfully');
    }

    /**
     * Remove the specified Principals from storage.
     * DELETE /principals/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Principals $principals */
        $principals = $this->principalsRepository->find($id);

        if (empty($principals)) {
            return $this->sendError('Principals not found');
        }

        $principals->delete();

        return $this->sendResponse($id, 'Principals deleted successfully');
    }
}

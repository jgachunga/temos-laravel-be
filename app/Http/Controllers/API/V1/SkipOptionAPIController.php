<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\API\V1\CreateSkipOptionAPIRequest;
use App\Http\Requests\API\V1\UpdateSkipOptionAPIRequest;
use App\Models\SkipOption;
use App\Repositories\Backend\SkipOptionRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class SkipOptionController
 * @package App\Http\Controllers\API\V1
 */

class SkipOptionAPIController extends AppBaseController
{
    /** @var  SkipOptionRepository */
    private $skipOptionRepository;

    public function __construct(SkipOptionRepository $skipOptionRepo)
    {
        $this->skipOptionRepository = $skipOptionRepo;
    }

    /**
     * Display a listing of the SkipOption.
     * GET|HEAD /skipOptions
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $skipOptions = $this->skipOptionRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($skipOptions->toArray(), 'Skip Options retrieved successfully');
    }

    /**
     * Store a newly created SkipOption in storage.
     * POST /skipOptions
     *
     * @param CreateSkipOptionAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateSkipOptionAPIRequest $request)
    {
        $input = $request->all();

        $skipOption = $this->skipOptionRepository->create($input);

        return $this->sendResponse($skipOption->toArray(), 'Skip Option saved successfully');
    }

    /**
     * Display the specified SkipOption.
     * GET|HEAD /skipOptions/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var SkipOption $skipOption */
        $skipOption = $this->skipOptionRepository->find($id);

        if (empty($skipOption)) {
            return $this->sendError('Skip Option not found');
        }

        return $this->sendResponse($skipOption->toArray(), 'Skip Option retrieved successfully');
    }

    /**
     * Update the specified SkipOption in storage.
     * PUT/PATCH /skipOptions/{id}
     *
     * @param int $id
     * @param UpdateSkipOptionAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSkipOptionAPIRequest $request)
    {
        $input = $request->all();

        /** @var SkipOption $skipOption */
        $skipOption = $this->skipOptionRepository->find($id);

        if (empty($skipOption)) {
            return $this->sendError('Skip Option not found');
        }

        $skipOption = $this->skipOptionRepository->update($input, $id);

        return $this->sendResponse($skipOption->toArray(), 'SkipOption updated successfully');
    }

    /**
     * Remove the specified SkipOption from storage.
     * DELETE /skipOptions/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var SkipOption $skipOption */
        $skipOption = $this->skipOptionRepository->find($id);

        if (empty($skipOption)) {
            return $this->sendError('Skip Option not found');
        }

        $skipOption->delete();

        return $this->sendSuccess('Skip Option deleted successfully');
    }
}

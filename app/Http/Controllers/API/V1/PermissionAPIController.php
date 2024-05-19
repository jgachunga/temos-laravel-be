<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\API\V1\CreatePermissionAPIRequest;
use App\Http\Requests\API\V1\UpdatePermissionAPIRequest;
use Spatie\Permission\Models\Permission;
use App\Repositories\Backend\Auth\PermissionRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class PermissionController
 * @package App\Http\Controllers\API\V1
 */

class PermissionAPIController extends AppBaseController
{
    /** @var  PermissionRepository */
    private $permissionRepository;

    public function __construct(PermissionRepository $permissionRepo)
    {
        $this->permissionRepository = $permissionRepo;
    }

    /**
     * Display a listing of the Permission.
     * GET|HEAD /permissions
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $page = $request->only('page');
        if(isset($page)&&!empty($page)){
            $permissions = Permission::where('guard_name', 'api')->orderByDesc('created_at')->paginate(5);
        }else{
            $permissions = $this->permissionRepository->where('guard_name', 'api')->all(
                $request->except(['skip', 'limit']),
                $request->get('skip'),
                $request->get('limit')
            );
        }

        return $this->sendResponse($permissions, 'Permissions retrieved successfully');
    }

    /**
     * Store a newly created Permission in storage.
     * POST /permissions
     *
     * @param CreatePermissionAPIRequest $request
     *
     * @return Response
     */
    public function store(CreatePermissionAPIRequest $request)
    {
        $input = $request->all();

        $permission = $this->permissionRepository->create($input);

        return $this->sendResponse($permission->toArray(), 'Permission saved successfully');
    }

    /**
     * Display the specified Permission.
     * GET|HEAD /permissions/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Permission $permission */
        $permission = $this->permissionRepository->find($id);

        if (empty($permission)) {
            return $this->sendError('Permission not found');
        }

        return $this->sendResponse($permission->toArray(), 'Permission retrieved successfully');
    }

    /**
     * Update the specified Permission in storage.
     * PUT/PATCH /permissions/{id}
     *
     * @param int $id
     * @param UpdatePermissionAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePermissionAPIRequest $request)
    {
        $input = $request->all();

        /** @var Permission $permission */
        $permission = $this->permissionRepository->find($id);

        if (empty($permission)) {
            return $this->sendError('Permission not found');
        }

        $permission = $this->permissionRepository->update($input, $id);

        return $this->sendResponse($permission->toArray(), 'Permission updated successfully');
    }

    /**
     * Remove the specified Permission from storage.
     * DELETE /permissions/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Permission $permission */
        $permission = $this->permissionRepository->find($id);

        if (empty($permission)) {
            return $this->sendError('Permission not found');
        }

        $permission->delete();

        return $this->sendResponse($id, 'Permission deleted successfully');
    }
}

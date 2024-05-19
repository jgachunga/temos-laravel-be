<?php

namespace App\Http\Controllers\API\V1\Auth\Role;

use App\Models\Auth\Role;
// use App\Http\Controllers\Controller;
use App\Events\Backend\Auth\Role\RoleDeleted;
use App\Repositories\Backend\Auth\RoleRepository;
use App\Repositories\Backend\Auth\PermissionRepository;
use App\Http\Requests\API\V1\Auth\Role\StoreRoleRequest;
use App\Http\Requests\API\V1\Auth\Role\ManageRoleRequest;
use App\Http\Requests\API\V1\Auth\Role\UpdateRoleRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\Auth\User;
use Response;
/**
 * Class RoleController.
 */
class RoleAPIController extends AppBaseController
{
    /**
     * @var RoleRepository
     */
    protected $roleRepository;

    /**
     * @var PermissionRepository
     */
    protected $permissionRepository;

    /**
     * @param RoleRepository       $roleRepository
     * @param PermissionRepository $permissionRepository
     */
    public function __construct(RoleRepository $roleRepository, PermissionRepository $permissionRepository)
    {
        $this->roleRepository = $roleRepository;
        $this->permissionRepository = $permissionRepository;
    }

    /**
     * @param ManageRoleRequest $request
     *
     * @return Response
     */
    public function index(ManageRoleRequest $request)
    {
        $page = $request->only('page');
        if(isset($page)&&!empty($page)){
            $roles = Role::with('permissions')->where('guard_name', 'api')->orderByDesc('created_at')->paginate(5);
        }else{
            $roles = $this->roleRepository->where('guard_name', 'api')->all(
                $request->except(['skip', 'limit']),
                $request->get('skip'),
                $request->get('limit')
            );
        }

        return $this->sendResponse($roles, 'Roles retrieved successfully');
    }
    public function supervisors(ManageRoleRequest $request)
    {
        $structures = $request->get('structures');
        $structure_id = $request->get('structure_id');
        if(isset($structure_id)){
            $users = User::whereHas("roles", function($q){ $q->where("name", "supervisor"); })->where('structure_id', $structure_id)->get();
        }else {
            $users = User::whereHas("roles", function($q){ $q->where("name", "supervisor"); })->whereIn('structure_id', $structures)->get();
        }

        return $this->sendResponse($users, 'Supervisors retrieved successfully');
    }

    /**
     * @param ManageRoleRequest $request
     *
     * @return mixed
     */
    public function create(ManageRoleRequest $request)
    {
        return view('backend.auth.role.create')
            ->withPermissions($this->permissionRepository->get());
    }

    /**
     * @param  StoreRoleRequest  $request
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function store(StoreRoleRequest $request)
    {
        $role = $this->roleRepository->create($request->only('name', 'associated-permissions', 'permissions', 'sort'));

        return $this->sendResponse($role->toArray(), 'Role saved successfully');
    }

    /**
     * @param ManageRoleRequest $request
     * @param Role              $role
     *
     * @return mixed
     */
    public function edit(ManageRoleRequest $request, Role $role)
    {
        if ($role->isAdmin()) {
            return redirect()->route('admin.auth.role.index')->withFlashDanger('You can not edit the administrator role.');
        }

        return view('backend.auth.role.edit')
            ->withRole($role)
            ->withRolePermissions($role->permissions->pluck('name')->all())
            ->withPermissions($this->permissionRepository->get());
    }

    /**
     * @param  UpdateRoleRequest  $request
     * @param  Role  $role
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        $this->roleRepository->update($role, $request->only('name', 'permissions'));

        return redirect()->route('admin.auth.role.index')->withFlashSuccess(__('alerts.backend.roles.updated'));
    }

    /**
     * @param ManageRoleRequest $request
     * @param Role              $role
     *
     * @throws \Exception
     * @return mixed
     */
    public function destroy(ManageRoleRequest $request, Role $role)
    {
        if ($role->isAdmin()) {
            return redirect()->route('admin.auth.role.index')->withFlashDanger(__('exceptions.backend.access.roles.cant_delete_admin'));
        }

        $this->roleRepository->deleteById($role->id);

        event(new RoleDeleted($role));

        return redirect()->route('admin.auth.role.index')->withFlashSuccess(__('alerts.backend.roles.deleted'));
    }
}

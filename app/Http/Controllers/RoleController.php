<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use App\Repositories\Repository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class RoleController extends Controller
{
    protected $role;

    public function __construct(Role $role)
    {
        parent::__construct();
        $this->middleware('permission:role-list');
        $this->middleware('permission:role-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
        $this->role = new Repository($role);
    }

    public function index(Request $request)
    {
        $items = $request->items ?? 10;
        $count = $this->role->all($items)->total();
        $roles = $this->role->all($items);
        return view('admin.role.list', compact('roles', 'items', 'count'));
    }

    public function create()
    {
        $permission = Permission::get();
        return view('admin.role.create', compact('permission'));
    }

    public function store(RoleRequest $request)
    {
        $roles = Role::create(['name' => $request->input('name')]);
        $roles->syncPermissions($request->input('permission'));
        return Response::json($roles);
    }

    public function show($id)
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
            ->where("role_has_permissions.role_id", $id)
            ->get();


        return view('roles.show', compact('role', 'rolePermissions'));
    }

    public function edit($id)
    {
        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();

        return view('admin.role.update', compact('role', 'rolePermissions', 'permission'));

    }

    public function update($id, RoleRequest $request)
    {
        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();
        $role->syncPermissions($request->input('permission'));
        return Response::json($role);
    }

    public function destroy($id)
    {
        $this->role->delete($id);
        return redirect()->route('role.index');
    }
}

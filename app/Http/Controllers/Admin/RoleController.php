<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Permission;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use Illuminate\Auth\Middleware\Authorize;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('roles.read');
        $roles = Role::whereNot('name', 'Super Admin')->withCount(['users'])->get();
        $permissions = Permission::all();
        $users = User::whereHas('roles', function($query) {
            $query->whereNot('name', 'Super Admin');
        })->latest()->paginate(12);
        $groupPermissions = $permissions->groupBy(function ($item, $key) {
            return $item['category'];
        });
        return view('admin.roles.index', compact('roles', 'groupPermissions', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRoleRequest $request)
    {
        $this->authorize('roles.create');
        if ($request->has('guard_name')) {
            $request['guard_name'] = 'web';
        }
        $role = Role::create($request->validated());
        if (!empty($request->permission)) {
            $permissions = Permission::whereIn('id', $request->permission)->get();
            $role->syncPermissions($permissions);
        }
        return redirect()->back()->with('success', 'Role created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $this->authorize('roles.update');
        $groupPermissions = Permission::all()->groupBy(function ($item, $key) {
            return $item['category'];
        });
        return view('admin.roles._edit-form', compact(['role', 'groupPermissions']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        $this->authorize('roles.update');
        $role->update($request->validated());
        if (empty($request->permission)) {
            $role->syncPermissions([]);
        } else {
            $permissions = Permission::whereIn('id', $request->permission)->get();
            $role->syncPermissions($permissions);
        }
        return redirect()->back()->with('success', 'Role updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $this->authorize('roles.delete');
        $role->delete();
        return redirect()->back()->with('success', 'Role deleted successfully');
    }
}

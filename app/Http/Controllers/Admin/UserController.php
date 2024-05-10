<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\ChangePasswordRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('users.read');
        $users = User::latest()->paginate(12);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $this->authorize('users.create');
        $user = User::create($request->only('name','email','is_active')+['password' => bcrypt($request->password)]);
        if (!$request->has('status')) {
            $user->is_active = 1;
        }
        // $role = Role::find($request->role);
        $user->assignRole($request->role);
        return redirect()->back()->with('success', 'User created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $this->authorize('users.read');
        $roles = Role::whereNot('name', 'Super Admin')->get();
        $userPermissions = $user->roles[0]->permissions->groupBy(function ($item, $key) {
            return $item['category'];
        });
        return view('admin.users.show', compact('user', 'roles', 'userPermissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $this->authorize('users.update');
        $user->update($request->only('name', 'username','contact','is_active')+['password' => bcrypt($request->password)]);
        if (!$request->has('is_active')) {
            $user->is_active = 1;
        }
        $user->save();
        if ($request->has('avatar')) {
            $user->addMediaFromRequest('avatar')->toMediaCollection('avatar');
        }
        $role = Role::findOrFail($request->role_id);
        if ($request->has('role')) {
            $user->syncRoles($role);
        }
        return redirect()->back()->with('success', 'User updated successfully');
    }

    public function changePassword(ChangePasswordRequest $request, User $user)
    {
        $this->authorize('users.update');
        $user->update([
            'password' => bcrypt($request->password)
        ]);
        return redirect()->back()->with('success', 'Password changed successfully');
    }

    public function destroy(User $user)
    {
        $this->authorize('users.delete');
        if($user->id == auth()->user()->id)
            return redirect()->back()->with('error', 'You can not delete yourself');
        if($user->hasRole('Super Admin'))
            return redirect()->back()->with('error', 'You can not delete Super Admin');
        $user->delete();
        return redirect()->back()->with('success', 'User deleted successfully');
    }

    public function suspend(User $user)
    {
        $this->authorize('users.update');
        if($user->id == auth()->user()->id)
            return redirect()->back()->with('error', 'You can not suspend yourself');
        if($user->hasRole('Super Admin'))
            return redirect()->back()->with('error', 'You can not suspend Super Admin');
        $user->is_active = 0;
        $user->save();
        return redirect()->back()->with('success', 'User suspended successfully');
    }

    public function unsuspend(User $user)
    {
        $this->authorize('users.update');
        if($user->id == auth()->user()->id)
            return redirect()->back()->with('error', 'You can not unsuspend yourself');
        if($user->hasRole('Super Admin'))
            return redirect()->back()->with('error', 'You can not unsuspend Super Admin');
        $user->is_active = 1;
        $user->save();
        return redirect()->back()->with('success', 'User unsuspended successfully');
    }
}

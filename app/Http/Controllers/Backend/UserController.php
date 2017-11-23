<?php

namespace Korona\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Hash;
use Mail;

use Korona\Http\Requests;
use Korona\Http\Controllers\Controller;
use Korona\User;
use Korona\Events\UserCreated;
use Korona\Repositories\UserRepository;
use Bican\Roles\Models\Role;
use Bican\Roles\Models\Permission;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:backend.manage.users');
    }

    public function index(UserRepository $repository)
    {
        $users = $repository->getAll();

        return view('backend.users.index', compact('users'));
    }

    public function trash(UserRepository $repository)
    {
        $users = $repository->getTrashed();

        return view('backend.users.trash', compact('users'));
    }

    public function create()
    {
        return view('backend.users.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'login' => 'required|max:255|unique:users,login',
            'email' => 'required|max:255|email|unique:users,email',
            'password' => 'required|confirmed|string|min:8|max:255'
        ]);

        $user = new User;
        $user->login = $request->login;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->active = $request->has('active');
        $user->force_password_change = $request->has('force_password_change');

        $user->save();

        $success = trans('backend.saved');
        if ($request->has('send_newaccount_email')) {
            $success .= ' ' . trans('backend.newaccount_email_sent');
        }

        event(new UserCreated($user, $request->password, $request->has('send_newaccount_email')));

        return redirect()->route('backend.user.edit', $user)
               ->with('success', $success);
    }

    public function show(User $user)
    {
        //
    }

    public function edit(User $user)
    {
        $roles = Role::all()->pluck('name', 'id')->all();

        if ($user->roles !== null) {
            $currentRoles = $user->roles->map(function ($item) {
                return $item->id;
            })->all();
        } else {
            $currentRoles = [];
        }

        $permissionsCollection = Permission::all();

        $permissions = [];
        foreach ($permissionsCollection as $permission) {
            $group = explode('.', $permission->slug)[0];
            $permissions[trans('backend.permissions.'.$group)][$permission->id] = $permission->name;
        }

        if ($user->userPermissions !== null) {
            $currentPermissions = $user->userPermissions->map(function ($item) {
                return $item->id;
            })->all();
        } else {
            $currentPermissions = [];
        }

        $permissionsCollection = $user->getPermissions();

        $effectivePermissions = [];
        if ($permissionsCollection !== null) {
            foreach ($permissionsCollection as $permission) {
                $group = explode('.', $permission->slug)[0];
                $effectivePermissions[trans('backend.permissions.'.$group)][$permission->id] = $permission->name;
            }
        }

        return view('backend.users.edit', compact('user', 'roles', 'currentRoles', 'permissions', 'currentPermissions', 'effectivePermissions'));
    }

    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'login' => 'required|max:255|unique:users,login,'.$user->id,
            'email' => 'required|max:255|email|unique:users,email,'.$user->id,
            'password' => 'confirmed|string|min:6',
            'roles' => 'array|exists:roles,id',
            'permissions' => 'array|exists:permissions,id',
        ]);

        $user->login = $request->login;
        $user->email = $request->email;
        $user->active = $request->has('active');
        if ($request->has('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->force_password_change = $request->has('force_password_change');

        $user->save();

        $user->detachAllRoles();
        if ($request->roles !== null) {
            foreach ($request->roles as $role) {
                $user->attachRole(Role::find($role));
            }
        }

        $user->detachAllPermissions();
        if ($request->permissions !== null) {
            foreach ($request->permissions as $permission) {
                $user->attachPermission(Permission::find($permission));
            }
        }

        $success = trans('backend.saved');
        if ($request->has('password') && $request->has('send_password_email')) {
            $this->sendPasswordEmail($user, $request->password);
            $success .= ' ' . trans('backend.password_email_sent');
        }

        return redirect()->route('backend.user.edit', $user)
               ->with('success', $success);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('backend.user.index')
               ->with('success', trans('backend.user_deleted', ['account' => $user->login]));
    }

    public function purge($id)
    {
        $user = User::withTrashed()->findOrFail($id);

        $user->forceDelete();

        return redirect()->route('backend.user.trash')
               ->with('success', trans('backend.user_purged', ['account' => $user->login]));
    }

    public function emptyTrash()
    {
        $user = User::onlyTrashed()->forceDelete();

        return redirect()->route('backend.user.trash')
               ->with('success', trans('backend.trash_emptied'));
    }

    public function restore($id)
    {
        $user = User::withTrashed()->findOrFail($id);

        $user->restore();

        return redirect()->route('backend.user.trash')
               ->with('success', trans('backend.user_restored', ['account' => $user->login]));
    }

    public function sendPasswordEmail(User $user, $password)
    {
        Mail::send(['mail.new_password', 'mail.plain.new_password'],
            ['user' => $user, 'password' => $password],
            function ($m) use ($user) {
                $m->to($user->email, $user->login);
                $m->subject(trans('mail.password_email_subject'));
            }
        );
    }
}

<?php

namespace Korona\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Hash;
use Mail;

use Korona\Http\Requests;
use Korona\Http\Controllers\Controller;
use Korona\User;
use Korona\Events\UserCreated;
use Korona\Repositories\MemberRepository;
use Korona\Repositories\UserRepository;
use Bican\Roles\Models\Role;
use Bican\Roles\Models\Permission;
use Illuminate\Support\Facades\Validator;
use Image;

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

    public function create(MemberRepository $memberRepo)
    {
        $members = $memberRepo->getActiveSelectData();

        return view('backend.users.create', compact('members'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'login' => 'required|max:255|unique:users,login',
            'email' => 'required|max:255|email|unique:users,email',
            'password' => 'required|confirmed|string|min:6',
            'member_id' => 'exists:members,id'
        ]);

        $user = new User;
        $user->login = $request->login;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->active = $request->has('active');
        $user->force_password_change = $request->has('force_password_change');

        $user->save();

        $member = \Korona\Member::find($request->member_id);
        $member->user()->associate($user);
        $member->save();

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

        if ($user->member !== null) {
            $user->member->user()->dissociate();
            $user->member->save();
        }
        $user->forceDelete();

        return redirect()->route('backend.user.trash')
               ->with('success', trans('backend.user_purged', ['account' => $user->login]));
    }

    public function emptyTrash()
    {
        $users = User::onlyTrashed()->get();

        foreach ($users as $user) {
            if ($user->member !== null) {
                $user->member->user()->dissociate();
                $user->member->save();
            }
            $user->forceDelete();
        }

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

    public function uploadPicture(User $user, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|image'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->messages()->first(),
                'code' => 400
            ], 400);
        }

        try {
            $image = Image::make($request->file('file'))
                     ->save(storage_path('app/local/profile/'.$user->id.'.jpg'));
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'code' => 500
            ], 500);
        }

        $user->picture = storage_path('app/local/profile/'.$user->id.'.jpg');
        $user->save();

        return response()->json('success', 200);
    }

    public function deletePicture(User $user)
    {
        if (file_exists($user->picture)) {
            @unlink($user->picture);
        }

        $user->picture = null;
        $user->save();

        return redirect()->route('backend.user.edit', $user)
               ->with('success', trans('backend.profile_picture_deleted'));
    }

    public function getCropForm(User $user)
    {
        if (! $user->picture) {
            return redirect()->route('backend.member.edit', $user)
                   ->with('error', trans('backend.no_picture_error'));
        }

        return view('backend.users.cropform', compact('user'));
    }

    public function cropPicture(User $user, Request $request)
    {
        $this->validate($request, [
            'x' => 'required|numeric',
            'y' => 'required|numeric',
            'width' => 'required|numeric',
            'height' => 'required|numeric'
        ]);

        if (! $user->picture) {
            return redirect()->route('backend.user.edit', $user)
                   ->with('error', trans('backend.no_picture_error'));
        }

        $x = round($request->x);
        $y = round($request->y);
        $width = round($request->width);
        $height = round($request->height);

        try {
            $image = Image::make($user->picture)
                     ->crop($width, $height, $x, $y)
                     ->resize(500, 500)
                     ->save($user->picture);
        } catch (Exception $e) {
            return redirect()->route('backend.user.cropform', $user)
                   ->with('error', trans('backend.picture_crop_error'));
        }

        return redirect()->route('backend.user.edit', $user)
               ->with('success', trans('backend.picture_cropped'));
    }
}

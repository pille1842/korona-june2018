<?php

namespace Korona\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Hash;
use Mail;

use Korona\Http\Requests;
use Korona\Http\Controllers\Controller;
use Korona\User;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:backend.manage.users');
    }

    public function index()
    {
        $users = User::all();

        return view('backend.users.index', compact('users'));
    }

    public function trash()
    {
        $users = User::onlyTrashed()->get();

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
            'slug'  => 'required|max:255|alpha_dash|unique:users,slug',
            'email' => 'required|max:255|email|unique:users,email',
            'password' => 'required|confirmed|string|min:8|max:255'
        ]);

        $user = new User;
        $user->login = $request->login;
        $user->slug = $request->slug;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->active = $request->has('active');
        $user->force_password_change = $request->has('force_password_change');

        $user->save();

        $success = trans('backend.saved');
        if ($request->has('send_newaccount_email')) {
            $this->sendNewAccountEmail($user, $request->password);
            $success .= ' ' . trans('backend.newaccount_email_sent');
        }

        return redirect()->route('backend.user.edit', $user)
               ->with('success', $success);
    }

    public function show(User $user)
    {
        //
    }

    public function edit(User $user)
    {
        return view('backend.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'login' => 'required|max:255|unique:users,login,'.$user->id,
            'slug'  => 'required|max:255|alpha_dash|unique:users,slug,'.$user->id,
            'email' => 'required|max:255|email|unique:users,email,'.$user->id,
            'password' => 'confirmed|string|min:8|max:255'
        ]);

        $user->login = $request->login;
        $user->slug  = $request->slug;
        $user->email = $request->email;
        $user->active = $request->has('active');
        $user->password = Hash::make($request->password);
        $user->force_password_change = $request->has('force_password_change');

        $user->save();

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

    public function sendNewAccountEmail(User $user, $password)
    {
        Mail::send(['mail.new_account', 'mail.plain.new_account'],
            ['user' => $user, 'password' => $password],
            function ($m) use ($user) {
                $m->to($user->email, $user->login);
                $m->subject(trans('mail.newaccount_email_subject'));
            }
        );
    }
}

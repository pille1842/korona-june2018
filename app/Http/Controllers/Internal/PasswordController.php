<?php

namespace Korona\Http\Controllers\Internal;

use Illuminate\Http\Request;
use Auth;
use Hash;

use Korona\Http\Requests;
use Korona\Http\Controllers\Controller;

class PasswordController extends Controller
{
    public function getForm()
    {
        return view('internal.password');
    }

    public function changePassword(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|min:6|confirmed'
        ]);

        $user = Auth::user();

        // Check if password has really changed
        if (Hash::check($request->password, $user->password)) {
            return redirect()->back()
                    ->withErrors(['password' => trans('internal.password_must_not_be_the_same')]);
        }

        $user->password = Hash::make($request->password);
        $user->force_password_change = false;
        $user->save();

        return redirect()->to('home')
                ->with('success', trans('internal.password_changed'));
    }
}

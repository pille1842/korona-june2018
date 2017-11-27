<?php

namespace Korona\Http\Controllers\Backend;

use Illuminate\Http\Request;

use Korona\Http\Requests;
use Korona\Http\Controllers\Controller;
use Korona\Email;

class EmailController extends Controller
{
    public function index()
    {
        //
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'emailable_type' => 'required',
            'emailable_id' => 'required',
            'redirect' => 'required'
        ]);

        return view('backend.emails.create', [
            'emailable_type' => $request->emailable_type,
            'emailable_id' => $request->emailable_id,
            'redirect' => $request->redirect
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'is_main' => 'boolean',
            'emailable_type' => 'required',
            'emailable_id' => 'required'
        ]);

        $email = new Email;
        $email->email = $request->email;
        $email->emailable_type = $request->emailable_type;
        $email->emailable_id = $request->emailable_id;

        $email->save();

        if ($request->has('is_main')) {
            $emailable = $email->emailable;
            $emailable->email_id = $email->id;
            $emailable->save();
        }

        return redirect()->to($email->emailable->getBackendEditUrl())
               ->with('success', trans('backend.saved'));
    }

    public function show($id)
    {
        //
    }

    public function edit(Email $email)
    {
        return view('backend.emails.edit', compact('email'));
    }

    public function update(Email $email, Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'is_main' => 'boolean'
        ]);

        $email->email = $request->email;
        $email->save();

        $emailable = $email->emailable;
        $emailable->email_id = $request->has('is_main') ? $email->id : null;
        $emailable->save();

        return redirect()->to($email->emailable->getBackendEditUrl())
               ->with('success', trans('backend.saved'));
    }

    public function destroy(Email $email)
    {
        $email->delete();

        $emailable = $email->emailable;
        if ($email->id == $emailable->email_id) {
            // Unset the member's main email ID to avoid inconsistent data
            $emailable->email_id = null;
            $emailable->save();
        }

        return redirect()->to($emailable->getBackendEditUrl())
               ->with('success', trans('backend.email_deleted', ['email' => $email->email]));
    }
}

<?php

namespace Korona\Http\Controllers\Backend;

use Illuminate\Http\Request;

use Korona\Http\Requests;
use Korona\Http\Controllers\Controller;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:backend.manage.settings');
    }

    public function index()
    {
        return view('backend.settings.index');
    }

    public function save(Request $request)
    {
        /* FRATERNITY SETTINGS */

        // Name of the fraternity
        settings(['fraternity.name' => $request->fraternity_name]);
        settings(['fraternity.vulgo' => $request->fraternity_vulgo]);
        settings(['fraternity.sine_nomine' => $request->fraternity_sine_nomine]);
        // Possible values for the status field of members
        $member_status_enum = explode(',', $request->fraternity_member_status_enum);
        $member_status_enum = array_map('trim', $member_status_enum);
        sort($member_status_enum);
        settings(['fraternity.member_status_enum' => $member_status_enum]);

        /* E-MAIL SETTINGS */

        // List of mail receivers to notify of changed members
        $member_changed_receivers = explode(',', $request->mail_member_changed_receivers);
        $member_changed_receivers = array_map('trim', $member_changed_receivers);
        sort($member_changed_receivers);
        settings(['mail.member_changed_receivers' => $member_changed_receivers]);

        return redirect()->route('backend.settings.index')
               ->with('success', trans('backend.saved'));
    }
}

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
        // Name of the fraternity
        settings(['fraternity.name' => $request->fraternity_name]);
        // Possible values for the status field of members
        $member_status_enum = explode(',', $request->fraternity_member_status_enum);
        $member_status_enum = array_map('trim', $member_status_enum);
        sort($member_status_enum);
        settings(['fraternity.member_status_enum' => $member_status_enum]);

        return view('backend.settings.index')
               ->with('success', trans('backend.saved'));
    }
}

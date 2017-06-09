<?php

namespace Korona\Http\Controllers\Backend;

use Illuminate\Http\Request;

use Korona\Http\Requests;
use Korona\Http\Controllers\Controller;
use Korona\Member;
use Korona\Office;

class OfficeController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:backend.manage.members');
    }

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Member $member, Request $request)
    {
        $this->validate($request, [
            'position' => 'required|in:' . implode(',', settings('fraternity.member_office_enum')),
            'begin' => 'date_format:d.m.Y',
            'end' => 'date_format:d.m.Y'
        ]);

        $office = new Office;
        $office->position = $request->position;
        $office->begin = $request->begin;
        if ($request->has('end')) {
            $office->end = $request->end;
        }

        $member->offices()->save($office);

        return redirect()->action('Backend\MemberController@edit', $member)
               ->with('success', trans('backend.saved'));
    }

    public function show(Member $member, Office $office)
    {
        //
    }

    public function edit(Member $member, Office $office)
    {
        //
    }

    public function update(Member $member, Request $request, Office $office)
    {
        //
    }

    public function destroy(Member $member, Office $office)
    {
        $office->delete();

        return redirect()->action('Backend\MemberController@edit', $member)
               ->with('success', trans('backend.saved'));
    }
}

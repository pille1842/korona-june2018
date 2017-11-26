<?php

namespace Korona\Http\Controllers\Backend;

use Illuminate\Http\Request;

use Korona\Http\Requests;
use Korona\Http\Controllers\Controller;
use Korona\Mailinglist;

class MailinglistController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:backend.manage.mailinglists');
    }

    public function index()
    {
        $mailinglists = Mailinglist::all();

        return view('backend.mailinglists.index', compact('mailinglists'));
    }

    public function create()
    {
        return view('backend.mailinglists.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'subscribable' => 'boolean'
        ]);

        $mailinglist = new Mailinglist;
        $mailinglist->name = $request->name;
        $mailinglist->subscribable = $request->has('subscribable');
        $mailinglist->save();

        return redirect()->route('backend.mailinglist.edit', $mailinglist)
               ->with('success', trans('backend.saved'));
    }

    public function show($id)
    {
        //
    }

    public function edit(Mailinglist $mailinglist)
    {
        return view('backend.mailinglists.edit', compact('mailinglist'));
    }

    public function update(Request $request, Mailinglist $mailinglist)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'subscribable' => 'boolean'
        ]);

        $mailinglist->name = $request->name;
        $mailinglist->subscribable = $request->has('subscribable');
        $mailinglist->save();

        return redirect()->route('backend.mailinglist.edit', $mailinglist)
               ->with('success', trans('backend.saved'));
    }

    public function destroy(Mailinglist $mailinglist)
    {
        $mailinglist->delete();

        return redirect()->route('backend.mailinglist.index')
               ->with('success', trans('backend.mailinglist_deleted', ['mailinglist' => $mailinglist->name]));
    }
}

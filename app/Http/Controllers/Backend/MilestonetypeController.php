<?php

namespace Korona\Http\Controllers\Backend;

use Illuminate\Http\Request;

use Korona\Http\Requests;
use Korona\Http\Controllers\Controller;
use Korona\Milestonetype;

class MilestonetypeController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:backend.manage.milestonetypes');
    }

    public function index()
    {
        $milestonetypes = Milestonetype::all();

        return view('backend.milestonetypes.index', compact('milestonetypes'));
    }

    public function create()
    {
        return view('backend.milestonetypes.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'symbol' => 'required|in:' . implode(',', Milestonetype::getIconsArray()),
            'template' => 'required'
        ]);

        $milestonetype = new Milestonetype;
        $milestonetype->name = $request->name;
        $milestonetype->symbol = $request->symbol;
        $milestonetype->template = $request->template;
        $milestonetype->save();

        return redirect()->route('backend.milestonetype.index')
               ->with('success', trans('backend.saved'));
    }

    public function show(Milestonetype $milestonetype)
    {
        //
    }

    public function edit(Milestonetype $milestonetype)
    {
        return view('backend.milestonetypes.edit', compact('milestonetype'));
    }

    public function update(Request $request, Milestonetype $milestonetype)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'symbol' => 'required|in:' . implode(',', Milestonetype::getIconsArray()),
            'template' => 'required'
        ]);

        $milestonetype->name = $request->name;
        $milestonetype->symbol = $request->symbol;
        $milestonetype->template = $request->template;
        $milestonetype->save();

        return redirect()->route('backend.milestonetype.index')
               ->with('success', trans('backend.saved'));
    }

    public function destroy(Milestonetype $milestonetype)
    {
        $milestonetype->delete();

        return redirect()->route('backend.milestonetype.index')
               ->with('success', trans('backend.milestonetype_deleted', ['milestonetype' => $milestonetype->name]));
    }
}

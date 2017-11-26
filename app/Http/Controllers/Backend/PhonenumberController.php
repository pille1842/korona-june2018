<?php

namespace Korona\Http\Controllers\Backend;

use Illuminate\Http\Request;

use Korona\Http\Requests;
use Korona\Http\Controllers\Controller;
use Korona\Country;
use Korona\Member;
use Korona\Phonenumber;

class PhonenumberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'type' => 'required|in:WORK,HOME,FAX,WORK_MOBILE,HOME_MOBILE,FAX_WORK,OTHER,OTHER_MOBILE',
            'country_id' => 'required|exists:countries,id',
            'phonenumber' => 'required|phonenumber:' . Country::find($request->country_id)->short,
            'phoneable_id' => 'required',
            'phoneable_type' => 'required'
        ]);

        $phonenumber = new Phonenumber;
        $phonenumber->type = $request->type;
        $phonenumber->country_id = $request->country_id;
        $phonenumber->phonenumber = $request->phonenumber;
        $phonenumber->phoneable_id = $request->phoneable_id;
        $phonenumber->phoneable_type = $request->phoneable_type;
        $phonenumber->save();

        return redirect()->to($phonenumber->phoneable->getBackendEditUrl())
               ->with('success', trans('backend.saved'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Phonenumber $phonenumber)
    {
        $phonenumber->delete();

        return redirect()->to($phonenumber->phoneable->getBackendEditUrl())
               ->with('success', trans('backend.phonenumber_deleted'));
    }
}

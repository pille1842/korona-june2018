<?php

namespace Korona\Http\Controllers\Backend;

use Illuminate\Http\Request;

use Korona\Http\Requests;
use Korona\Http\Controllers\Controller;
use Korona\Address;
use Korona\Member;
use Korona\Country;

class AddressController extends Controller
{
    public function index()
    {
        //
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'addressable_type' => 'required',
            'addressable_id' => 'required',
            'redirect' => 'required'
        ]);

        $countries = Country::all()->pluck('name', 'id');

        return view('backend.addresses.create', [
            'addressable_type' => $request->addressable_type,
            'addressable_id' => $request->addressable_id,
            'redirect' => $request->redirect,
            'countries' => $countries
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'max:255',
            'additional' => 'max:255',
            'street' => 'max:255',
            'zipcode' => 'max:20',
            'city' => 'max:255',
            'province' => 'max:255',
            'country_id' => 'exists:countries,id',
            'is_main' => 'boolean',
            'addressable_type' => 'required',
            'addressable_id' => 'required',
            'redirect' => 'required'
        ]);

        $address = new Address;
        $address->name = $request->name;
        $address->additional = $request->additional;
        $address->street = $request->street;
        $address->zipcode = $request->zipcode;
        $address->city = $request->city;
        $address->province = $request->province;
        $address->country_id = $request->country_id;
        $address->addressable_type = $request->addressable_type;
        $address->addressable_id = $request->addressable_id;

        $address->save();

        if ($request->has('is_main')) {
            $addressable = $address->addressable;
            $addressable->address_id = $address->id;
            $addressable->save();
        }

        return redirect()->to($request->redirect)
               ->with('success', trans('backend.saved'));
    }

    public function show($id)
    {
        //
    }

    public function edit(Address $address)
    {
        $countries = Country::all()->pluck('name', 'id');

        return view('backend.addresses.edit', compact('address', 'countries'));
    }

    public function update(Address $address, Request $request)
    {
        $this->validate($request, [
            'name' => 'max:255',
            'additional' => 'max:255',
            'street' => 'max:255',
            'zipcode' => 'max:20',
            'city' => 'max:255',
            'province' => 'max:255',
            'country_id' => 'exists:countries,id',
            'is_main' => 'boolean'
        ]);

        $address->name = $request->name;
        $address->additional = $request->additional;
        $address->street = $request->street;
        $address->zipcode = $request->zipcode;
        $address->city = $request->city;
        $address->province = $request->province;
        $address->country_id = $request->country_id;
        $address->save();

        $addressable = $address->addressable;
        $addressable->address_id = $request->has('is_main') ? $address->id : null;
        $addressable->save();

        return redirect()->to($address->addressable->getBackendEditUrl())
               ->with('success', trans('backend.saved'));
    }

    public function destroy(Address $address)
    {
        $address->delete();

        $addressable = $address->addressable;
        if ($address->id == $addressable->address_id) {
            // Unset the member's main address ID to avoid inconsistent data
            $addressable->address_id = null;
            $addressable->save();
        }

        return redirect()->to($addressable->getBackendEditUrl())
               ->with('success', trans('backend.address_deleted', ['address' => $address->name]));
    }
}

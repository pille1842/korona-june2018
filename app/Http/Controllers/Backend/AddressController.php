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
    public function __construct()
    {
        $this->middleware('permission:backend.manage.members');
    }

    public function index()
    {
        //
    }

    public function create(Member $member)
    {
        $countries = Country::all()->pluck('name', 'id');

        return view('backend.addresses.create', compact('member', 'countries'));
    }

    public function store(Member $member, Request $request)
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

        $address = new Address;
        $address->name = $request->name;
        $address->additional = $request->additional;
        $address->street = $request->street;
        $address->zipcode = $request->zipcode;
        $address->city = $request->city;
        $address->province = $request->province;
        $address->country_id = $request->country_id;

        $member->addresses()->save($address);

        if ($request->has('is_main')) {
            $member->address_id = $address->id;
            $member->save();
        }

        return redirect()->route('backend.member.edit', $member)
               ->with('success', trans('backend.saved'));
    }

    public function show($id)
    {
        //
    }

    public function edit(Member $member, Address $address)
    {
        $countries = Country::all()->pluck('name', 'id');

        return view('backend.addresses.edit', compact('address', 'countries'));
    }

    public function update(Member $member, Address $address, Request $request)
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

        if ($request->has('is_main')) {
            $member->address_id = $address->id;
            $member->save();
        }

        return redirect()->route('backend.member.edit', $member)
               ->with('success', trans('backend.saved'));
    }

    public function destroy(Member $member, Address $address)
    {
        $address->delete();

        if ($address->id == $member->address_id) {
            // Unset the member's main address ID to avoid inconsistent data
            $member->address_id = null;
            $member->save();
        }

        return redirect()->route('backend.member.edit', $member)
               ->with('success', trans('backend.address_deleted', ['address' => $address->name]));
    }
}

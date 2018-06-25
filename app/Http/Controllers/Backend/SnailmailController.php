<?php

namespace Korona\Http\Controllers\Backend;

use Illuminate\Http\Request;

use Korona\Http\Requests;
use Korona\Http\Controllers\Controller;
use Korona\Mailinglist;
use Korona\Generators\LabelGenerator;
use Korona\Generators\InternetmarkeGenerator;

class SnailmailController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:backend.access.snailmail');
    }

    public function index()
    {
        $mailinglists = Mailinglist::all()->pluck('name', 'id')->prepend('', '');

        return view('backend.snailmail.index', compact('mailinglists'));
    }

    public function getLabels(Request $request)
    {
        $this->validate($request, [
            'mailinglist' => 'required|exists:mailinglists,id'
        ]);

        $mailinglist = Mailinglist::findOrFail($request->mailinglist);
        LabelGenerator::getLabels($mailinglist);
    }

    public function getInternetmarke(Request $request)
    {
        $this->validate($request, [
            'mailinglist' => 'required|exists:mailinglists,id',
            'foreign' => 'boolean'
        ]);

        $mailinglist = Mailinglist::findOrFail($request->mailinglist);

        $csv = InternetmarkeGenerator::getCsv($mailinglist, $request->has('foreign'));
        $filename = $request->has('foreign') ? 'internetmarke_foreign.csv' : 'internetmarke_domestic.csv';

        return response()->attachment($csv, 'text/csv', $filename);
    }

    public function getReceiversInfo(Request $request)
    {
        $this->validate($request, [
            'mailinglist' => 'required|exists:mailinglists,id'
        ]);

        $mailinglist = Mailinglist::findOrFail($request->mailinglist);
        $countries = [];
        $receivers_domestic = 0;
        $receivers_foreign = 0;
        $noaddress = [];
        $members = collect($mailinglist->members);
        $people = collect($mailinglist->people);
        $receivers = $members->merge($people);

        foreach ($receivers as $receiver) {
            if ($receiver->address === null) {
                $noaddress[] = $receiver->getFullName();
            } else {
                if ($receiver->address->country->id == settings('fraternity.home_country')) {
                    $receivers_domestic += 1;
                } else {
                    $receivers_foreign += 1;
                }
                if (! isset($countries[$receiver->address->country->id])) {
                    $countries[$receiver->address->country->id] = 0;
                }
                $countries[$receiver->address->country->id] += 1;
            }
        }

        if (count($members) > 0 && count($people) > 0) {
            $receiversType = trans('backend.received_by_members_and_people');
        } elseif (count($members) > 0 && count($people) == 0) {
            $receiversType = trans('backend.received_by_members');
        } elseif (count($members) == 0 && count($people) > 0) {
            $receiversType = trans('backend.received_by_people');
        } else {
            $receiversType = trans('backend.received_by_noone');
        }

        return view('backend.snailmail.receiversinfo',
               compact('countries', 'receivers_domestic', 'receivers_foreign', 'noaddress', 'receiversType'));
    }
}

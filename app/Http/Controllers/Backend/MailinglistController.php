<?php

namespace Korona\Http\Controllers\Backend;

use Illuminate\Http\Request;

use Korona\Http\Requests;
use Korona\Http\Controllers\Controller;
use Korona\Mailinglist;
use Korona\Member;
use Korona\Person;
use Korona\Repositories\MemberRepository;

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

    public function edit(MemberRepository $memberRepo, Mailinglist $mailinglist)
    {
        $nonmembers = $memberRepo->getActive()->reject(function ($item) use ($mailinglist) {
            foreach ($item->subscriptions as $subscription) {
                if ($subscription->id == $mailinglist->id) {
                    return true;
                }
            }
            return false;
        })->map(function ($item) {
            $item->displayName = $item->getFullName(true, true);
            return $item;
        })->pluck('displayName', 'id')->all();
        $nonpeople = Person::all()->reject(function ($item) use ($mailinglist) {
            foreach ($item->subscriptions as $subscription) {
                if ($subscription->id == $mailinglist->id) {
                    return true;
                }
            }
            return false;
        })->map(function ($item) {
            $item->displayName = $item->getFullName(true);
            return $item;
        })->pluck('displayName', 'id')->all();

        return view('backend.mailinglists.edit', compact('mailinglist', 'nonmembers', 'nonpeople'));
    }

    public function update(Request $request, Mailinglist $mailinglist)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'subscribable' => 'boolean',
            'addmembers' => 'array',
            'addpeople' => 'array'
        ]);

        $mailinglist->name = $request->name;
        $mailinglist->subscribable = $request->has('subscribable');

        if ($request->has('addmembers')) {
            foreach ($request->addmembers as $memberId) {
                $member = Member::findOrFail($memberId);
                $mailinglist->members()->save($member);
            }
        }

        if ($request->has('addpeople')) {
            foreach ($request->addpeople as $personId) {
                $person = Person::findOrFail($personId);
                $mailinglist->people()->save($person);
            }
        }

        $mailinglist->save();

        return redirect()->route('backend.mailinglist.edit', $mailinglist)
               ->with('success', trans('backend.saved'));
    }

    public function unsubscribe(Mailinglist $mailinglist, Request $request)
    {
        $this->validate($request, [
            'subscribableType' => 'required|in:Korona\Member,Korona\Person',
            'subscribableId' => 'required|int'
        ]);

        switch ($request->subscribableType) {
            case 'Korona\Member':
                $subscribable = Member::findOrFail($request->subscribableId);
                $mailinglist->members()->detach($subscribable);
                break;
            case 'Korona\Person':
                $subscribable = Person::findOrFail($request->subscribableId);
                $mailinglist->people()->detach($subscribable);
                break;
        }

        $mailinglist->save();

        return redirect()->route('backend.mailinglist.edit', $mailinglist)
               ->with('success', trans('backend.subscriber_removed', ['subscriber' => $subscribable->getFullName()]));
    }

    public function destroy(Mailinglist $mailinglist)
    {
        $mailinglist->delete();

        return redirect()->route('backend.mailinglist.index')
               ->with('success', trans('backend.mailinglist_deleted', ['mailinglist' => $mailinglist->name]));
    }
}

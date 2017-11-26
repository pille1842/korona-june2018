<?php

namespace Korona\Http\Controllers\Backend;

use Illuminate\Http\Request;

use Carbon\Carbon;
use Korona\Country;
use Korona\Http\Controllers\Controller;
use Korona\Http\Requests;
use Korona\Person;
use Korona\Mailinglist;

class PersonController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:backend.manage.people');
    }

    public function index()
    {
        $people = Person::all();

        return view('backend.people.index', compact('people'));
    }

    public function trash()
    {
        $people = Person::onlyTrashed()->get();

        return view('backend.people.trash', compact('people'));
    }

    public function create()
    {
        return view('backend.people.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nickname' => 'string|max:255',
            'firstname' => 'required|max:255',
            'lastname' => 'required|max:255',
            'sex' => 'in:MALE,FEMALE'
        ]);

        $person = new Person;
        $person->nickname = $request->nickname;
        $person->firstname = $request->firstname;
        $person->lastname = $request->lastname;
        $person->sex = $request->sex;

        $person->save();

        return redirect()->route('backend.person.edit', $person)
               ->with('success', trans('backend.saved'));
    }

    public function show(Person $person)
    {
        //
    }

    public function edit(Person $person)
    {
        $countries = Country::all()->map(function ($item) {
            $item->displayName = $item->name . ' (+' . $item->phoneprefix . ')';
            return $item;
        })->pluck('displayName', 'id');

        $mailinglists = Mailinglist::all()->pluck('name', 'id');

        if ($person->subscriptions !== null) {
            $subscriptions = $person->subscriptions->map(function ($item) {
                return $item->id;
            })->all();
        } else {
            $subscriptions = [];
        }

        return view('backend.people.edit', compact('person', 'countries', 'mailinglists', 'subscriptions'));
    }

    public function update(Request $request, Person $person)
    {
        $this->validate($request, [
            'nickname' => 'string|max:255',
            'firstname' => 'required|max:255',
            'lastname' => 'required|max:255',
            'inverse_name_order' => 'boolean',
            'appellation' => 'max:255',
            'sex' => 'in:MALE,FEMALE',
            'title_prefix' => 'max:255',
            'title_suffix' => 'max:255'
        ]);

        $person->nickname = $request->nickname;
        $person->firstname = $request->firstname;
        $person->lastname = $request->lastname;
        $person->inverse_name_order = $request->has('inverse_name_order');
        $person->appellation = $request->appellation;
        $person->sex = $request->sex;
        $person->title_prefix = $request->title_prefix;
        $person->title_suffix = $request->title_suffix;
        $person->notes = $request->notes;

        $person->subscriptions()->detach();
        if ($request->subscriptions !== null) {
            foreach ($request->subscriptions as $subscription) {
                $person->subscriptions()->attach(Mailinglist::find($subscription));
            }
        }

        $person->save();

        return redirect()->route('backend.person.edit', $person)
               ->with('success', trans('backend.saved'));
    }

    public function destroy(Person $person)
    {
        $person->delete();

        return redirect()->route('backend.person.index')
               ->with('success', trans('backend.person_deleted', ['person' => $person->getFullName()]));
    }

    public function purge($id)
    {
        $person = Person::onlyTrashed()->findOrFail($id);

        $person->forceDelete();

        return redirect()->route('backend.person.trash')
               ->with('success', trans('backend.person_purged', ['person' => $person->getFullName()]));
    }

    public function emptyTrash()
    {
        $people = Person::onlyTrashed();

        foreach ($people as $person) {
            $person->forceDelete();
        }

        return redirect()->route('backend.person.trash')
               ->with('success', trans('backend.trash_emptied'));
    }

    public function restore($id)
    {
        $person = Person::withTrashed()->findOrFail($id);

        $person->restore();

        return redirect()->route('backend.person.trash')
               ->with('success', trans('backend.person_restored', ['person' => $person->getFullName()]));
    }
}

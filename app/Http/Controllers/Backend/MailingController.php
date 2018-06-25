<?php

namespace Korona\Http\Controllers\Backend;

use Auth;
use Illuminate\Http\Request;
use Korona\Generators\Markdown;
use Korona\Http\Controllers\Controller;
use Korona\Http\Requests;
use Korona\Jobs\SendEmail;
use Korona\Mailing;
use Korona\Mailinglist;
use Korona\Member;
use Korona\Person;
use Korona\Repositories\MemberRepository;
use Log;

class MailingController extends Controller
{
    public function index()
    {
        $mailings = Mailing::all();
        $mailinglists = Mailinglist::all()->pluck('name', 'id')->prepend('', '');

        return view('backend.mailings.index', compact('mailings', 'mailinglists'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $mailing = new Mailing;
        $mailing->save();

        return redirect()->route('backend.mailing.edit', $mailing);
    }

    public function show(Mailing $mailing)
    {
        $members = collect($mailing->mailinglist->members);
        $people = collect($mailing->mailinglist->people);
        $receivers = $members->merge($people)->map(function ($item) {
            if ($item->email == null) {
                return null;
            }
            $item->classAndId = get_class($item) . ':' . $item->id;
            $item->displayName = $item->getFullName() . ' <' . $item->email->email . '>';
            return $item;
        })->pluck('displayName', 'classAndId');

        return view('backend.mailings.show', compact('mailing', 'receivers'));
    }

    public function edit(MemberRepository $memberRepo, Mailing $mailing)
    {
        if ($mailing->sent_at !== null) {
            return redirect()->back()->with('error', trans('backend.mailing_already_sent'));
        }

        if ($mailing->sender == null) {
            $mailing->sender = Auth::user()->member;
        }

        $mailinglists = Mailinglist::all()->pluck('name', 'id');
        $members = $memberRepo->getSelectDataWithPrimaryEmail();

        return view('backend.mailings.edit', compact('mailing', 'mailinglists', 'members'));
    }

    public function update(Request $request, Mailing $mailing)
    {
        if ($mailing->sent_at !== null) {
            return redirect()->back()->with('error', trans('backend.mailing_already_sent'));
        }

        $this->validate($request, [
            'mailinglist' => 'required|exists:mailinglists,id',
            'sender' => 'required|exists:members,id',
            'subject' => 'required|max:255',
            'layout' => 'required|in:default,bereavement',
            'text' => 'required'
        ]);

        if ($request->sender != Auth::user()->member->id && ! Auth::user()->can('backend.mailings.setsender')) {
            // This user has no permission to set any sender but himself!
            return redirect()->back()
                   ->withInput()->with('error', trans('backend.permission_denied_set_sender'));
        }

        $mailing->mailinglist_id = $request->mailinglist;
        $mailing->sender_id = $request->sender;
        $mailing->subject = $request->subject;
        $mailing->layout = $request->layout;
        $mailing->text = $request->text;
        $mailing->save();

        return redirect()->route('backend.mailing.edit', $mailing)
            ->with('success', trans('backend.saved'));
    }

    public function copy(Mailing $mailing)
    {
        $copy = new Mailing;
        $copy->subject = $mailing->subject;
        $copy->layout = $mailing->layout;
        $copy->text = $mailing->text;
        $copy->mailinglist_id = $mailing->mailinglist_id;
        if (Auth::user()->can('backend.mailings.setsender')) {
            $copy->sender_id = $mailing->sender_id;
        } else {
            $copy->sender_id = Auth::user()->member->id;
        }
        $copy->save();

        return redirect()->route('backend.mailing.edit', $copy)
            ->with('success', trans('backend.copied'));
    }

    public function destroy(Mailing $mailing)
    {
        if ($mailing->sent_at !== null) {
            return redirect()->back()
                   ->with('error', trans('backend.mailing_already_sent'));
        }

        $mailing->delete();

        return redirect()->route('backend.mailing.index')
            ->with('success', trans('backend.mailing_deleted'));
    }

    public function getReceiversInfo(Request $request)
    {
        $this->validate($request, [
            'mailinglist' => 'required|exists:mailinglists,id'
        ]);

        $mailinglist = Mailinglist::findOrFail($request->mailinglist);
        $receiversCount = 0;
        $membersCount = 0;
        $peopleCount = 0;
        $noaddress = [];
        $members = collect($mailinglist->members);
        $people = collect($mailinglist->people);
        $receivers = $members->merge($people);

        foreach ($receivers as $receiver) {
            if ($receiver->email === null) {
                $noaddress[] = $receiver->getFullName();
            } else {
                $receiversCount += 1;
                if ($receiver instanceof Member) {
                    $membersCount += 1;
                } else {
                    $peopleCount += 1;
                }
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

        return view(
            'backend.mailings.receiversinfo',
            compact(
                'receiversCount', 'membersCount', 'peopleCount',
                'noaddress', 'receiversType'
            )
        );
    }

    public function preview(Mailing $mailing, Request $request)
    {
        $this->validate($request, [
            'receiver' => 'required|regex:/[\w]+:[0-9]+/'
        ]);

        $arrReceiver = explode(':', $request->receiver);
        $class = $arrReceiver[0];
        $id = $arrReceiver[1];
        switch ($class) {
            case 'Korona\Member':
                $objReceiver = Member::findOrFail($id);
                break;
            case 'Korona\Person':
                $objReceiver = Person::findOrFail($id);
                break;
            default:
                throw new Exception('Unknown receiver type: ' . $class);
        }
        $environment = [
            'fullname' => $objReceiver->getFullName(),
            'name'     => $objReceiver->getShortName(),
            'salutation_formal' => $objReceiver->getFormalSalutation(),
            'salutation_informal' => $objReceiver->getInformalSalutation()
        ];
        $markdown = new Markdown($environment);
        $body = $markdown->text($mailing->text);

        return view('mail.mailing.' . $mailing->layout, ['receiver' => $objReceiver, 'mailing' => $mailing, 'body' => $body]);
    }

    public function send(Mailing $mailing)
    {
        if (! Auth::user()->can('backend.mailings.send')) {
            return redirect()->back()->with('error', trans('backend.permission_denied_send_mailing'));
        }

        $mailinglist = $mailing->mailinglist;
        $members = collect($mailinglist->members);
        $people = collect($mailinglist->people);
        $receivers = $members->merge($people);

        foreach ($receivers as $receiver) {
            $this->dispatch(new SendEmail($receiver, $mailing));
        }

        $mailing->sent_at = date('Y-m-d H:i:s');
        $mailing->save();

        Log::info(trans('backend.user_sent_mailing', ['mailing' => $mailing->id, 'user' => Auth::user()->member->getFullName()]));

        return redirect()->route('backend.mailing.index')
            ->with('success', trans('backend.mailing_sent'));
    }
}

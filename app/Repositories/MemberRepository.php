<?php

namespace Korona\Repositories;

use Korona\Member;

class MemberRepository
{
    public function getAll()
    {
        return Member::all();
    }

    public function getTrashed()
    {
        return Member::onlyTrashed()->get();
    }

    public function getAllWithTrashed()
    {
        return Member::withTrashed()->get();
    }

    public function getActive()
    {
        return Member::where('active', true)->get();
    }

    public function getSelectData()
    {
        return $this->getAll()->map(function ($item) {
            $item->displayName = $item->getFullName();
            return $item;
        })->pluck('displayName', 'id')->prepend('', '')->all();
    }

    public function getActiveSelectData()
    {
        return $this->getActive()->map(function ($item) {
            $item->displayName = $item->getFullName();
            return $item;
        })->pluck('displayName', 'id')->prepend('', '')->all();
    }

    public function getSelectDataWithPrimaryEmail()
    {
        return $this->getAll()->map(function ($item) {
            if ($item->email == null) {
                return null;
            }
            $item->displayName = $item->getFullName() . ' <' . $item->email->email . '>';
            return $item;
        })->pluck('displayName', 'id')->prepend('', '')->all();
    }
}

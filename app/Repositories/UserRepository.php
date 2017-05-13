<?php

namespace Korona\Repositories;

use Korona\User;

class UserRepository
{
    public function getAll()
    {
        return User::all();
    }

    public function getTrashed()
    {
        return User::onlyTrashed()->get();
    }

    public function getAllWithTrashed()
    {
        return User::withTrashed()->get();
    }

    public function getActive()
    {
        return User::where('active', true)->get();
    }
}

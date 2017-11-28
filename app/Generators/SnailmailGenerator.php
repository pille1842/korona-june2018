<?php

namespace Korona\Generators;

use Korona\Mailinglist;
use Korona\Member;
use Korona\Person;

class SnailmailGenerator
{
    public static function collectReceivers(Mailinglist $mailinglist)
    {
        $members = collect($mailinglist->members);
        $people = collect($mailinglist->people);

        return $members->merge($people)->sortBy('lastname');
    }
}

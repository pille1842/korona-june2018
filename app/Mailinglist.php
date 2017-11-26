<?php

namespace Korona;

use Illuminate\Database\Eloquent\Model;

class Mailinglist extends Model
{
    public function members()
    {
        return $this->morphedByMany('Korona\Member', 'subscribable');
    }

    public function people()
    {
        return $this->morphedByMany('Korona\Person', 'subscribable');
    }
}

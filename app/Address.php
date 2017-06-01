<?php

namespace Korona;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $revisionNullString = 'nichts';
    protected $revisionUnknownString = 'unbekannt';

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function identifiableName()
    {
        return $this->name . ' (' . $this->street . ', '
               . $this->zipcode . ' ' . $this->city . ', '
               . $this->country->name . ')';
    }
}

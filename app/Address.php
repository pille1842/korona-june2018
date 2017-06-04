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

    public function getFormatted()
    {
        $address = "";
        if ($this->additional) {
            $address .= $this->additional . "\n";
        }
        $address .= $this->street . "\n";
        $address .= trim($this->zipcode . " " . $this->city);
        if ($this->country->id != settings("fraternity.home_country")) {
            $address .= "\n" . $this->country->name;
        }

        return $address;
    }
}

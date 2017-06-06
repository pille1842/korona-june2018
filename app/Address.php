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

        if ($this->country->short != "HU") {
            if ($this->additional) {
                $address .= $this->additional . "\n";
            }
            $address .= $this->street . "\n";
            $address .= $this->formatCityLine();
            if ($this->country->id != settings("fraternity.home_country")) {
                $address .= "\n" . $this->country->name;
            }
        } else {
            // Hungary's format is so different, we can't do it automatically.
            if ($this->additional) {
                $address .= $this->additional . "\n";
            }
            $address .= $this->city . "\n";
            $address .= $this->street . "\n";
            $address .= $this->zipcode;
            if ($this->country->id != settings("fraternity.home_country")) {
                $address .= "\n" . $this->country->name;
            }
        }

        return $address;
    }

    private function formatCityLine()
    {
        $format = $this->country->cityline;
        $result = str_replace('\n', "\n", $format);
        $result = str_replace(':city', $this->city, $result);
        $result = str_replace(':province', $this->province, $result);
        $result = str_replace(':zip', $this->zipcode, $result);

        return trim($result);
    }
}

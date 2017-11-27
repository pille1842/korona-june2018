<?php

namespace Korona;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    protected $revisionNullString = 'nichts';
    protected $revisionUnknownString = 'unbekannt';

    public function emailable()
    {
        return $this->morphTo();
    }

    public function identifiableName()
    {
        return $this->email;
    }
}

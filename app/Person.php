<?php

namespace Korona;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;
use Korona\Interfaces\PersonInterface;

class Person extends Model implements PersonInterface
{
    use RevisionableTrait;
    use SoftDeletes;

    protected $revisionCreationsEnabled = true;

    protected $dontKeepRevisionOf = [
        'address_id',
        'email_id',
        'notes'
    ];

    protected $revisionFormattedFields = [
        'inverse_name_order' => 'boolean:Nein|Ja'
    ];

    protected $revisionFormattedFieldNames = [
        'nickname' => 'Biername',
        'firstname' => 'Vorname',
        'lastname' => 'Nachname',
        'inverse_name_order' => 'Umgekehrte Namensreihenfolge',
        'sex' => 'Geschlecht',
        'title_prefix' => 'Titel (Präfix)',
        'title_suffix' => 'Titel (Suffix)',
        'appellation' => 'Anrede',
        'profession' => 'Beruf',
        'address' => 'Adresse',
        'email' => 'E-Mail-Adresse',
        'phonenumber' => 'Telefonnummer',
    ];

    protected $revisionNullString = 'nichts';

    protected $revisionUnknownString = 'unbekannt';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function identifiableName()
    {
        return $this->getShortName();
    }

    public function getFullName($withTitle = false)
    {
        return trim($this->getCivilName($withTitle) . ' ' . $this->getQualifiedNickname());
    }

    public function getCivilName($withTitle = false)
    {
        if ($withTitle) {
            return trim($this->title_prefix . ' ' . $this->getNamesInOrder() . ' ' . $this->title_suffix);
        } else {
            return $this->getNamesInOrder();
        }
    }

    public function getNamesInOrder()
    {
        if ($this->inverse_name_order) {
            return $this->lastname . ' ' . $this->firstname;
        } else {
            return $this->firstname . ' ' . $this->lastname;
        }
    }

    public function getShortName()
    {
        return $this->nickname ? $this->nickname : $this->getFullName();
    }

    public function getQualifiedNickname()
    {
        return $this->nickname ? settings('fraternity.vulgo') . ' ' . $this->nickname : '';
    }

    public function getBackendEditUrl()
    {
        return route('backend.person.edit', $this);
    }

    public function addresses()
    {
        return $this->morphMany('Korona\Address', 'addressable');
    }

    public function emails()
    {
        return $this->morphMany('Korona\Email', 'emailable');
    }

    public function email()
    {
        return $this->hasOne(Email::class, 'email_id');
    }

    public function phonenumbers()
    {
        return $this->morphMany('Korona\Phonenumber', 'phoneable');
    }

    public function address()
    {
        return $this->hasOne(Address::class, 'address_id');
    }

    public function subscriptions()
    {
        return $this->morphToMany('Korona\Mailinglist', 'subscribable');
    }
}

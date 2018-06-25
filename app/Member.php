<?php

namespace Korona;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;
use Carbon\Carbon;
use Collective\Html\Eloquent\FormAccessible;
use Korona\Interfaces\PersonInterface;

class Member extends Model implements PersonInterface
{
    use RevisionableTrait;
    use SoftDeletes;
    use FormAccessible;

    protected $revisionCreationsEnabled = true;

    protected $dontKeepRevisionOf = [
        'user_id',
        'picture',
        'address_id',
        'email_id'
    ];

    protected $revisionFormattedFields = [
        'slug' => '<tt>%s</tt>',
        'birthday' => 'datetime:d.m.Y',
        'active' => 'boolean:Nein|Ja',
        'inverse_name_order' => 'boolean:Nein|Ja'
    ];

    protected $revisionFormattedFieldNames = [
        'parent_id' => 'Leibbursch',
        'slug' => 'SEO-URL',
        'nickname' => 'Biername',
        'firstname' => 'Vorname',
        'lastname' => 'Nachname',
        'inverse_name_order' => 'Umgekehrte Namensreihenfolge',
        'birthname' => 'Geburtsname',
        'sex' => 'Geschlecht',
        'title_prefix' => 'Titel (Präfix)',
        'title_suffix' => 'Titel (Suffix)',
        'profession' => 'Beruf',
        'birthday' => 'Geburtstag',
        'status' => 'Status',
        'active' => 'aktiv',
        'address' => 'Adresse',
        'email' => 'E-Mail-Adresse',
        'phonenumber' => 'Telefonnummer',
    ];

    protected $revisionNullString = 'nichts';

    protected $revisionUnknownString = 'unbekannt';

    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'birthday'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function identifiableName()
    {
        return $this->getShortName();
    }

    public function getFullName($withTitle = false, $withStatus = false)
    {
        return trim(($withStatus ? $this->status : '') . ' ' . $this->getCivilName($withTitle) . ' ' . $this->getQualifiedNickname());
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
        return $this->nickname ? settings('fraternity.vulgo') . ' ' . $this->nickname : settings('fraternity.sine_nomine');
    }

    public function getFormalSalutation()
    {
        $salutation  = settings('mail.salutation_formal_member_' . strtolower($this->sex)) . ' ';
        $salutation .= trim($this->title_prefix . ' ' . $this->lastname . ' ' . $this->title_suffix);

        return $salutation;
    }

    public function getInformalSalutation()
    {
        $salutation  = settings('mail.salutation_informal_member_' . strtolower($this->sex)) . ' ';
        $salutation .= $this->nickname ? $this->nickname : $this->firstname;;

        return $salutation;
    }

    public function getBackendEditUrl()
    {
        return route('backend.member.edit', $this);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        return $this->belongsTo(Member::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Member::class, 'parent_id');
    }

    public function addresses()
    {
        return $this->morphMany('Korona\Address', 'addressable');
    }

    public function emails()
    {
        return $this->morphMany('Korona\Email', 'emailable');
    }

    public function phonenumbers()
    {
        return $this->morphMany('Korona\Phonenumber', 'phoneable');
    }

    public function offices()
    {
        return $this->hasMany(Office::class);
    }

    public function address()
    {
        return $this->hasOne(Address::class, 'id', 'address_id');
    }

    public function email()
    {
        return $this->hasOne(Email::class, 'id', 'email_id');
    }

    public function subscriptions()
    {
        return $this->morphToMany('Korona\Mailinglist', 'subscribable');
    }

    public function formBirthdayAttribute($value)
    {
        return Carbon::parse($value)->format('d.m.Y');
    }

    public function setBirthdayAttribute($value)
    {
        if (! $value instanceof \Carbon\Carbon) {
            $this->attributes['birthday'] = Carbon::createFromFormat('d.m.Y', $value);
        } else {
            $this->attributes['birthday'] = $value;
        }
    }
}

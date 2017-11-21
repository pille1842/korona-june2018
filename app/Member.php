<?php

namespace Korona;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;
use Carbon\Carbon;
use Collective\Html\Eloquent\FormAccessible;

class Member extends Model
{
    use RevisionableTrait;
    use SoftDeletes;
    use FormAccessible;

    protected $revisionCreationsEnabled = true;

    protected $dontKeepRevisionOf = [
        'user_id',
        'profile_picture',
        'address_id'
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
        'title' => 'Akadem. Titel',
        'profession' => 'Beruf',
        'birthday' => 'Geburtstag',
        'status' => 'Status',
        'active' => 'aktiv',
        'address' => 'Adresse',
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

    public function getFullName($withTitle = false)
    {
        return trim($this->getCivilName($withTitle) . ' ' . $this->getQualifiedNickname());
    }

    public function getCivilName($withTitle = false)
    {
        if ($withTitle) {
            return trim($this->title . ' ' . $this->getNamesInOrder());
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

    public function picture()
    {
        return $this->BelongsTo(Media\Image::class, 'profile_picture');
    }

    public function profilePictureRoute()
    {
        if ($this->picture !== null) {
            return route('image', $this->picture);
        } else {
            return asset('images/no_profile_picture.jpg');
        }
    }

    public function images()
    {
        return $this->morphMany(Media\Image::class, 'imageable');
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function phonenumbers()
    {
        return $this->hasMany(Phonenumber::class);
    }

    public function offices()
    {
        return $this->hasMany(Office::class);
    }

    public function address()
    {
        return $this->hasOne(Address::class, 'address_id');
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

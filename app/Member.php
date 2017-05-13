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
        'user_id'
    ];

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
        return $this->getCivilName($withTitle) . ' ' . $this->getQualifiedNickname();
    }

    public function getCivilName($withTitle = false)
    {
        if ($withTitle) {
            return trim($this->title . ' ' . $this->firstname . ' ' . $this->lastname);
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
        return $this->nickname ? 'ṽ. ' . $this->nickname : 's.n.';
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

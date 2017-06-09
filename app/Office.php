<?php

namespace Korona;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Office extends Model
{
    protected $dates = ['created_at', 'updated_at', 'begin', 'end'];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public static function getPositionArray()
    {
        $positions = settings('fraternity.member_office_enum');
        $result = [];

        foreach ($positions as $position) {
            $result[$position] = $position;
        }

        return $result;
    }

    public function formBeginAttribute($value)
    {
        return Carbon::parse($value)->format('d.m.Y');
    }

    public function setBeginAttribute($value)
    {
        if (! $value instanceof \Carbon\Carbon) {
            $this->attributes['begin'] = Carbon::createFromFormat('d.m.Y', $value);
        } else {
            $this->attributes['begin'] = $value;
        }
    }

    public function formEndAttribute($value)
    {
        return Carbon::parse($value)->format('d.m.Y');
    }

    public function setEndAttribute($value)
    {
        if (! $value instanceof \Carbon\Carbon) {
            $this->attributes['end'] = Carbon::createFromFormat('d.m.Y', $value);
        } else {
            $this->attributes['end'] = $value;
        }
    }
}

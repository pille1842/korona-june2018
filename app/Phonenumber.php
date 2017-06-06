<?php

namespace Korona;

use Illuminate\Database\Eloquent\Model;

class Phonenumber extends Model
{
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function getFormatted()
    {
        if ($this->country->id == settings('fraternity.home_country')) {
            $format = \libphonenumber\PhoneNumberFormat::NATIONAL;
        } else {
            $format = \libphonenumber\PhoneNumberFormat::INTERNATIONAL;
        }

        $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();

        try {
            $numberProto = $phoneUtil->parse($this->phonenumber, $this->country->short);
            $numberStr   = $phoneUtil->format($numberProto, $format);
        } catch (\libphonenumber\NumberParseException $e) {
            $numberStr   = $this->phonenumber;
        }

        return $numberStr;
    }

    public static function getTypeArray()
    {
        return [
            'HOME' => trans('backend.phonenumbertypes.HOME'),
            'WORK' => trans('backend.phonenumbertypes.WORK'),
            'FAX' => trans('backend.phonenumbertypes.FAX'),
            'FAX_WORK' => trans('backend.phonenumbertypes.FAX_WORK'),
            'HOME_MOBILE' => trans('backend.phonenumbertypes.HOME_MOBILE'),
            'WORK_MOBILE' => trans('backend.phonenumbertypes.WORK_MOBILE'),
            'OTHER' => trans('backend.phonenumbertypes.OTHER'),
            'OTHER_MOBILE' => trans('backend.phonenumbertypes.OTHER_MOBILE')
        ];
    }
}

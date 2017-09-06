<?php

namespace Korona;

use Illuminate\Database\Eloquent\Model;
use Korona\Member;

class Milestonetype extends Model
{
    public static function getIconsArray()
    {
        $icons = explode(',', file_get_contents(resource_path('fontawesome-icons.csv')));

        return array_combine($icons, $icons);
    }

    public function format(Member $member, $param)
    {
        $txt = $this->template;
        $txt = str_replace(':member', $member->getShortName(), $txt);
        $txt = str_replace(':param', $param, $txt);

        return $txt;
    }
}

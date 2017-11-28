<?php

namespace Korona\Generators;

use Korona\Mailinglist;
use Korona\Member;
use Korona\Person;

class LabelGenerator extends SnailmailGenerator
{
    public static function getLabels(Mailinglist $mailinglist)
    {
        $receivers = self::collectReceivers($mailinglist);
        $pdf = new LabelPdf(settings('snailmail.sender'), $receivers);
        $pdf->labels();
    }
}

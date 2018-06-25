<?php

namespace Korona\Generators;

use Korona\Mailinglist;
use Korona\Country;

class InternetmarkeGenerator extends SnailmailGenerator
{
    public static function getCsv(Mailinglist $mailinglist, $foreign = false)
    {
        $receivers = self::collectReceivers($mailinglist);
        $csv = "NAME;ZUSATZ;STRASSE;NUMMER;PLZ;STADT;LAND;ADRESS_TYP\r\n";

        $sender_name = settings('snailmail.internetmarke_name');
        $sender_zusatz = settings('snailmail.internetmarke_zusatz');
        $sender_strasse = settings('snailmail.internetmarke_strasse');
        $sender_nummer = settings('snailmail.internetmarke_nummer');
        $sender_plz = settings('snailmail.internetmarke_plz');
        $sender_stadt = settings('snailmail.internetmarke_stadt');
        $country_id = settings('snailmail.internetmarke_land');
        $sender_land = Country::find($country_id)->short3;
        $sender_adress_typ = settings('snailmail.internetmarke_adress_typ');

        $csv .= "{$sender_name};{$sender_zusatz};{$sender_strasse};" .
                "{$sender_nummer};{$sender_plz};{$sender_stadt};{$sender_land};" .
                "{$sender_adress_typ}\r\n";

        foreach ($receivers as $receiver) {
            if ($receiver->address === null) {
                continue;
            }
            if ($foreign && $receiver->address->country->id == settings('fraternity.home_country')) {
                continue;
            }
            if (! $foreign && $receiver->address->country->id != settings('fraternity.home_country')) {
                continue;
            }
            $address = $receiver->address;
            $csv .= $receiver->getCivilName(true) . ';';
            $csv .= $address->additional . ';';
            $csv .= $address->street . ';;';
            $csv .= $address->zipcode . ';';
            $csv .= $address->city . ';';
            $csv .= $address->country->short3 . ";HOUSE\r\n";
        }
        $csv = iconv('UTF-8', 'CP1252', $csv);

        return $csv;
    }
}

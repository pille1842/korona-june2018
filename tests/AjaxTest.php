<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AjaxTest extends TestCase
{
    /**
     * Test that the slugifying route (/ajax/slug?input=XYZ) responds with the
     * correct slugs for a number of strings.
     *
     * @return void
     */
    public function testSlugifyingStringsWorks()
    {
        $arrInput = [
            'Ich bin ein Satz'  =>
                'ich-bin-ein-satz',
            'Umlaute ändern nichts' =>
                'umlaute-aendern-nichts',
            'Franz jagt im völlig verwahrlosten Taxi quer durch Bayern.' =>
                'franz-jagt-im-voellig-verwahrlosten-taxi-quer-durch-bayern',
            'Hüben wie drüben stehen große Fässer!' =>
                'hueben-wie-drueben-stehen-grosse-faesser',
        ];

        foreach ($arrInput as $input => $expectation) {
            $response = $this->call('GET', 'ajax/slug?input='.urlencode($input));
            $this->assertEquals($expectation, $response->content());
        }
    }
}

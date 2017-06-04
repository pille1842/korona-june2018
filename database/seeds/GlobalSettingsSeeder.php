<?php

use Illuminate\Database\Seeder;

class GlobalSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = [
            'fraternity.name' => 'PV Korona',
            'fraternity.home_country' => 43,
            'fraternity.member_status_enum' => [
                'aF',
                'aB',
                'iaB',
                'CK',
                'AH',
                'AH h.c.',
                'EAH',
            ],
            'fraternity.vulgo' => 'ṽ.',
            'fraternity.sine_nomine' => 's.n.',
            'mail.member_changed_receivers' => [
                'test@example.com',
                'another@example.com',
            ],
        ];

        foreach($settings as $key => $value) {
            settings([$key => $value]);
        }
    }
}

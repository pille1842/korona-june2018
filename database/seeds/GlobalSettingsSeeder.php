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
        $settings = json_decode(file_get_contents(resource_path('settings.json')), true);

        foreach ($settings['system'] as $group) {
            $prefix = $group['name'] . '.';

            foreach ($group['settings'] as $setting) {
                settings([
                    $prefix.$setting['name'] => $setting['value']
                ]);
            }
        }
    }
}

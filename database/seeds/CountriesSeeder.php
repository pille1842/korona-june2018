<?php

use Illuminate\Database\Seeder;
use Korona\Country;

class CountriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (($handle = fopen(resource_path("countries.csv"), "r")) !== false) {
            while (($data = fgetcsv($handle, 1000, ";")) !== false) {
                $country        = new Country;
                $country->short = $data[0];
                $country->name  = $data[1];
                $country->save();
            }
            fclose($handle);
        }
    }
}

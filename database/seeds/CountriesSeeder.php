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
                $country              = new Country;
                $country->short       = $data[0];
                $country->short3      = $data[1];
                $country->name        = $data[2];
                $country->phoneprefix = $data[3];
                $country->cityline    = $data[4];
                $country->save();
            }
            fclose($handle);
        }
    }
}

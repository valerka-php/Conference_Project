<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $response = file_get_contents(__DIR__.'/lib/countries.json');
        $countries = json_decode($response);

        foreach ($countries as $country){
            DB::table('countries')->insert([
                'id' => $country->id,
                'name' => $country->name,
                'short_name' => $country->short_name,
                'country_code' => $country->country_code,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}

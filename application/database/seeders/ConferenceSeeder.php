<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConferenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 21; $i++) {
            DB::table('conferences')->insert([
                'id' => $i,
                'creator_id' => 2,
                'title' => 'Test Conf' . $i,
                'date' => '2022-02-02',
                'latitude' => '50.005716',
                'longitude' => '36.229177',
                'country' => 'Ukraine',
                'category_id' => 3,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}

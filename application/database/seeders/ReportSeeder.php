<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i <= 20; $i++) {
            DB::table('reports')->insert([
                'creator_id' => 2,
                'conference_id' => 1,
                'title' => 'Test Report' . $i,
                'description' => 'some text test',
                'presentation' => 'presentation/test',
                'start_time' => "0$i:00:00",
                'end_time' => "0" . $i + 1 . ":00:00",
                'category_id' => 3,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}

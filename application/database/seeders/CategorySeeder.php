<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i <= 4; $i++) {
            DB::table('categories')->insert([
                'id' => $i + 1,
                'title' => "Parent Category $i",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }

        for ($i = 0; $i <= 15; $i++) {
            DB::table('categories')->insert([
                'id' => 6 + $i,
                'title' => "Child Category $i",
                'parent_category_id' => rand(1, 5),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}

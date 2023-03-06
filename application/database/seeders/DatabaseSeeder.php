<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(
            [
                CountrySeeder::class,
                RoleSeeder::class,
                UserSeeder::class,
                CategorySeeder::class,
                ConferenceSeeder::class,
                ReportSeeder::class,
                CommentSeeder::class,
                PlanSeeder::class,
                SubscriptionSeeder::class,
            ]
        );
    }
}

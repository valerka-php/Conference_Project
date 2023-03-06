<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();

        foreach ($users as $user) {
            if ($user->role_id !== User::ROLE_ADMIN && $user->stripe_id === null) {
                $user->newSubscription('free', 'price_1MYqAkJyBoavg6HnCzScOykA')->add();
            }
        }
    }
}

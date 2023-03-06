<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $plans = [
            [
                'id' => 1,
                'name' => 'free',
                'stripe_plan' => 'price_1MYqAkJyBoavg6HnCzScOykA',
                'price' => '0',
                'count_joins' => 1,
                'description' => 'subscription free for one conference in a month',
            ],
            [
                'id' => 2,
                'name' => '5 conferences',
                'stripe_plan' => 'price_1MYqEtJyBoavg6HnNUAsHN2P',
                'price' => '15',
                'count_joins' => 5,
                'description' => 'Allows subscribe to five conferences in a month',
            ],
            [
                'id' => 3,
                'name' => '50 conferences',
                'stripe_plan' => 'price_1MYqFaJyBoavg6HnhKHDOdr1',
                'price' => '25',
                'count_joins' => 50,
                'description' => 'Allows subscribe up to fifty conferences in a month',
            ],
            [
                'id' => 4,
                'name' => 'unlimited',
                'stripe_plan' => 'price_1MYqHcJyBoavg6Hn8oboZ52m',
                'price' => '100',
                'count_joins' => 'unlimited',
                'description' => 'Allows subscribe to unlimited conferences in a month',
            ],
        ];

        foreach ($plans as $plan) {
            Plan::create($plan);
        }
    }
}

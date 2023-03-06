<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Plan>
 */
class PlanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => '50 conferences',
            'stripe_plan' => 'price_1MYqFaJyBoavg6HnhKHDOdr1',
            'price' => '25',
            'count_joins' => 50,
            'description' => 'Allows subscribe up to fifty conferences in a month',
        ];
    }
}

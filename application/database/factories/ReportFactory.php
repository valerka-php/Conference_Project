<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Conference;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Report>
 */
class ReportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'creator_id' => User::factory(),
            'conference_id' => Conference::factory(),
            'title' => 'Test Report',
            'description' => 'some text test',
            'presentation' => 'presentation/test',
            'start_time' => "02:00:00",
            'end_time' => "03:00:00",
            'category_id' => Category::factory(),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
    }
}

<?php

namespace Tests\Feature\Search;

use App\Models\Conference;
use App\Models\User;
use Database\Seeders\CategorySeeder;
use Database\Seeders\CountrySeeder;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class SearchConferenceTest extends TestCase
{
    use RefreshDatabase;

    public function afterRefreshingDatabase()
    {
        $this->seed([
            RoleSeeder::class,
            CountrySeeder::class,
            CategorySeeder::class,
        ]);
    }

    public function testSearchConference()
    {
        $user = User::factory()->create();
        $this->be($user);

        for ($i = 1; $i <= 5; $i++) {
            Conference::factory()->create([
                'title' => "Test $i",
                'date' => '2023-03-25'
            ]);
        }

        $this->get(route('search.index', [
            'title' => 'Test 4',
            'checkbox' => ["conference" => 1]
        ]))->assertInertia(fn(Assert $page) => $page
            ->component('Search/ShowResult')
            ->has('conferences', 1));
    }
}

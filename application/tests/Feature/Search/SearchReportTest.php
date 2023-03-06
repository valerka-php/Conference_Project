<?php

namespace Tests\Feature\Search;

use App\Models\Conference;
use App\Models\Report;
use App\Models\User;
use Database\Seeders\CategorySeeder;
use Database\Seeders\CountrySeeder;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class SearchReportTest extends TestCase
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
        $user = User::factory()->create(['role_id' => User::ROLE_ANNOUNCER]);

        $this->be($user);

        $conference = Conference::factory()->create(['date' => '2023-03-30']);

        for ($i = 1; $i <= 5; $i++) {
            Report::factory()->create([
                'conference_id' => $conference->id,
                'title' => "Report $i",
                'start_time' => "0$i:00:00",
                'end_time' => "0" . $i + 1 . ":00:00",
            ]);
        }

        $this->get(route('search.index', [
            'title' => 'Report 4',
            'checkbox' => ["report" => 1]
        ]))->assertInertia(fn(Assert $page) => $page
            ->component('Search/ShowResult')
            ->has('reports', 1));
    }
}

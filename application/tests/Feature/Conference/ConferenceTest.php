<?php

namespace Tests\Feature\Conference;


use App\Models\Conference;
use App\Models\User;
use Database\Seeders\CategorySeeder;
use Database\Seeders\CountrySeeder;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class ConferenceTest extends TestCase
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

    public function testJoinListenerToConference()
    {
        $user = User::factory()->create([
            'id' => 7,
            'role_id' => User::ROLE_LISTENER
        ]);

        $this->be($user);

        $conference = Conference::factory()->create();

        $this->put(route('conferences.join', ['conference' => $conference->id]));

        $this->assertDatabaseHas('user_conference', [
            'user_id' => $user->id,
            'conference_id' => $conference->id,
        ]);
    }

    public function testJoinAnnouncerToConference()
    {
        $user = User::factory()->create(['role_id' => User::ROLE_ANNOUNCER]);

        $this->be($user);

        $conference = Conference::factory()->create();

        $this
            ->get(route('reports.create', ['conference' => $conference->id]))
            ->assertInertia(fn(Assert $page) => $page
                ->component('Report/CreateReport')
            );

        $this->post(route('reports.store', [
            'conference' => $conference->id,
            "online" => "0",
            "conference_id" => $conference->id,
            "title" => "Test Case",
            "description" => "Officia ut labore qu",
            "start_time" => "18:0",
            "end_time" => "19:0",
            "category_id" => "2",
        ]))
            ->assertRedirect(route('home'));

        $this->assertDatabaseHas('user_conference', [
            'user_id' => $user->id,
            'conference_id' => $conference->id,
        ]);
    }

    public function testJoinGuestToConference()
    {
        $this->get(route('reports.create', ['conference' => 1]))
            ->assertRedirect('/login');
    }

    public function testDeleteAdminConference()
    {
        $user = User::factory()->create(['role_id' => User::ROLE_ADMIN]);

        $this->be($user);

        $conference = Conference::factory()->create();

        $this
            ->delete(route('conferences.delete', ['conference' => $conference->id]))
            ->assertRedirect(route('home'));

        $this->assertDatabaseMissing('conferences', [
            'id' => $conference->id,
        ]);
    }

}

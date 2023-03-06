<?php

namespace Tests\Feature\Report;

use App\Models\Report;
use App\Models\User;
use Database\Seeders\CategorySeeder;
use Database\Seeders\ConferenceSeeder;
use Database\Seeders\CountrySeeder;
use Database\Seeders\ReportSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class ReportTest extends TestCase
{
    use RefreshDatabase;

    public function afterRefreshingDatabase()
    {
        $this->seed([
            RoleSeeder::class,
            CountrySeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            ConferenceSeeder::class,
        ]);
    }

    public function testRenderCreateReportPage()
    {
        $this
            ->be(User::factory()->create())
            ->get(route('reports.create', ['conference' => 1]))
            ->assertInertia(fn(Assert $page) => $page
                ->component('Report/CreateReport')
            );
    }

    public function testNotRenderCreateReportPage()
    {
        $this
            ->be(User::factory()->create())
            ->get(route('reports.create', ['conference' => 1758]))
            ->assertStatus(404);
    }

    public function testAnnouncerCreateReport()
    {
        $this->be(User::factory()->create(['role_id' => User::ROLE_ANNOUNCER]))
            ->post(route('reports.store', [
                'conference' => 1,
                "online" => "0",
                "conference_id" => 1,
                "title" => "Test Case",
                "description" => "Officia ut labore qu",
                "start_time" => "18:0",
                "end_time" => "19:0",
                "category_id" => "2",
            ]))
            ->assertRedirect(route('home'));

        $this->assertDatabaseHas('reports', [
            'title' => 'Test Case',
        ]);
    }

    public function testListenerCreateReport()
    {
        $this->be(User::factory()->create(['role_id' => User::ROLE_LISTENER]))
            ->post(route('reports.store', [
                'conference' => 1,
                "online" => "0",
                "conference_id" => 1,
                "title" => "Test Case",
                "description" => "Officia ut labore qu",
                "start_time" => "18:0",
                "end_time" => "19:0",
                "category_id" => "2",
            ]))
            ->assertStatus(403);
    }

    public function testAdminCreateReport()
    {
        $this->be(User::factory()->create(['role_id' => User::ROLE_ADMIN]))
            ->post(route('reports.store', [
                'conference' => 1,
                "online" => "0",
                "conference_id" => 1,
                "title" => "Test Case",
                "description" => "Officia ut labore qu",
                "start_time" => "18:0",
                "end_time" => "19:0",
                "category_id" => "2",
            ]))
            ->assertRedirect(route('home'));

        $this->assertDatabaseHas('reports', [
            'title' => 'Test Case',
        ]);
    }

    public function testGuestCreateReport()
    {
        $this->post(route('reports.store', [
            'conference' => 1,
            "online" => "0",
            "conference_id" => 1,
            "title" => "Test Case",
            "description" => "Officia ut labore qu",
            "start_time" => "18:0",
            "end_time" => "19:0",
            "category_id" => "2",
        ]))
            ->assertRedirect(route('login'));
    }

    public function testCreatorDeleteReport()
    {
        $user = User::factory()->create();
        $report = Report::factory()->create([
            'creator_id' => $user->id,
            'conference_id' => 7,
            'title' => 'Test Case Report',
            'id' => 77,
        ]);

        $this->be($user);

        $this->delete(route('reports.delete', ['report' => $report->id]))
            ->assertRedirect(route('home'));

        $this->assertDatabaseMissing('reports', ['title' => 'Test Case Report']);
    }

    public function testAdminDeleteReport()
    {
        $this->seed(ReportSeeder::class);
        $user = User::factory()->create(['role_id' => User::ROLE_ADMIN]);
        $report = Report::factory()->create([
            'conference_id' => 7,
            'title' => 'Test Case Report',
            'id' => 77,
        ]);

        $this->be($user);

        $this->delete(route('reports.delete', ['report' => $report->id]))
            ->assertRedirect(route('home'));

        $this->assertDatabaseMissing('reports', ['title' => 'Test Case Report']);
    }

    public function testCreatorUpdateReport()
    {
        $user = User::factory()->create();
        $report = Report::factory()->create([
            'creator_id' => $user->id,
            'conference_id' => 7,
            'title' => 'Test Case Report',
            'id' => 77,
        ]);

        $this->be($user);

        $this->post(route('reports.update', [
            'report' => $report->id,
            'conference' => $report->conference_id,
            'title' => 'Test Case Updated',
            'start_time' => '12:00',
            'end_time' => '13:00',
            'description' => 'Test',
        ]))
            ->assertRedirect('/report/77');

        $this->assertDatabaseHas('reports', ['title' => 'Test Case Updated']);
    }

    public function testAdminUpdateReport()
    {
        $user = User::factory()->create(['role_id' => User::ROLE_ADMIN]);
        $report = Report::factory()->create([
            'creator_id' => $user->id,
            'conference_id' => 7,
            'title' => 'Test Case Report',
            'id' => 77,
        ]);

        $this->be($user);

        $this->post(route('reports.update', [
            'report' => $report->id,
            'conference' => $report->conference_id,
            'title' => 'Test Case Updated',
            'start_time' => '12:00',
            'end_time' => '13:00',
            'description' => 'Test',
        ]))
            ->assertRedirect('/report/77');

        $this->assertDatabaseHas('reports', ['title' => 'Test Case Updated']);
    }

}

<?php

namespace Tests\Feature\Filter;

use App\Models\Category;
use App\Models\Conference;
use App\Models\Report;
use App\Models\User;
use Database\Seeders\CountrySeeder;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class FilterTest extends TestCase
{
    use RefreshDatabase;

    public function afterRefreshingDatabase()
    {
        $this->seed([
            RoleSeeder::class,
            CountrySeeder::class,
        ]);
    }

    public function testConferenceFilterByDate()
    {
        $user = User::factory()->create();

        $this->be($user);

        for ($i = 1; $i <= 5; $i++) {
            Conference::factory()->create([
                'title' => "Test $i",
                'date' => "2023-02-2" . $i
            ]);

            Report::factory()->create([
                'start_time' => "0$i:00:00",
                'end_time' => "0" . $i + 1 . ":00:00",
            ]);
        }

        $this->get(route('home', [
            'report_count' => [0, 5],
            'date' => [
                'min' => '2023-02-21',
                'max' => '2023-02-21',
            ]
        ]))->assertInertia(fn(Assert $page) => $page
            ->component('Welcome')
            ->has('paginatedConferences.data', 1));
    }

    public function testConferenceFilterByCategory()
    {
        $this->withExceptionHandling();

        $user = User::factory()->create();
        $category = Category::factory()->create();

        $this->be($user);

        for ($i = 1; $i <= 5; $i++) {
            Conference::factory()->create([
                'title' => "Test $i",
                'date' => "2023-02-2" . $i,
                'category_id' => $category->id
            ]);

            Report::factory()->create();
        }

        $this->get(route('home', [
            'category_id' => [$category->id],
            'report_count' => [0, 5],
            'date' => [
                'min' => '2023-02-21',
                'max' => '2023-02-22',
            ]
        ]))->assertInertia(fn(Assert $page) => $page
            ->component('Welcome')
            ->has('paginatedConferences.data', 2));
    }

    public function testConferenceFilterByCount()
    {
        $user = User::factory()->create();

        $this->be($user);

        $conference = Conference::factory()->create(['date' => '2023-03-25']);

        for ($i = 1; $i <= 5; $i++) {
            Report::factory()->create([
                'start_time' => "0$i:00:00",
                'end_time' => "0" . $i + 1 . ":00:00",
                'conference_id' => $conference->id
            ]);
        }

        $this->get(route('home', [
            'report_count' => [5, 5],
            'date' => [
                'min' => $conference->date,
                'max' => $conference->date,
            ]
        ]))->assertInertia(fn(Assert $page) => $page
            ->component('Welcome')
            ->has('paginatedConferences.data', 1));
    }

    public function testReportFilterByTime()
    {
        $user = User::factory()->create();

        $this->be($user);

        $conference = Conference::factory()->create([
            'title' => "Test 1",
            'date' => "2023-03-25",
        ]);

        for ($i = 20; $i <= 22; $i++) {
            Report::factory()->create([
                'start_time' => "$i:00:00",
                'end_time' => $i + 1 . ":00:00",
                'conference_id' => $conference->id,
            ]);
        }

        $this->get(route('reports.show', [
            'conference' => $conference->id,
            "conference_id" => $conference->id,
            "report_time" => "01:00:00",
            'period_of_time' => [
                "start_time" => "22:00",
                "end_time" => "23:00"
            ]
        ]))->assertInertia(fn(Assert $page) => $page
            ->component('Report/ShowReports')
            ->has('reports.data', 1));
    }

    public function testReportFilterByCategory()
    {
        $this->withExceptionHandling();

        $user = User::factory()->create();

        $this->be($user);

        $category = Category::factory()->create();
        $conference = Conference::factory()->create([
            'date' => "2023-03-25",
        ]);

        for ($i = 20; $i <= 22; $i++) {
            Report::factory()->has(Conference::factory()->count(1))->create([
                'start_time' => "$i:00:00",
                'end_time' => $i + 1 . ":00:00",
                'conference_id' => $conference->id,
                'category_id' => $category->id,
            ]);
        }

        $this->get(route('reports.show', [
            'conference' => $conference->id,
            "conference_id" => $conference->id,
            "report_time" => "01:00:00",
            'category_id' => [$category->id],
        ]))->assertInertia(fn(Assert $page) => $page
            ->component('Report/ShowReports')
            ->has('reports.data', 3));
    }

    public function testReportFilterByReportTime()
    {
        $user = User::factory()->create();

        $this->be($user);

        $conference = Conference::factory()->create([
            'date' => '2023-03-25'
        ]);

        Report::factory()->create([
            'start_time' => "20:30:00",
            'end_time' => "20:45:00",
            'conference_id' => $conference->id
        ]);

        Report::factory()->create([
            'start_time' => "20:45:00",
            'end_time' => "21:00:00",
            'conference_id' => $conference->id
        ]);

        $this->get(route('reports.show', [
            'conference' => $conference->id,
            "conference_id" => $conference->id,
            "report_time" => "00:15:00",
        ]))->assertInertia(fn(Assert $page) => $page
            ->component('Report/ShowReports')
            ->has('reports.data', 2));
    }

}

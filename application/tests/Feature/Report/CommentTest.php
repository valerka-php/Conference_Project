<?php

namespace Tests\Feature\Report;

use App\Models\Comment;
use App\Models\Conference;
use App\Models\Report;
use App\Models\User;
use Database\Seeders\CategorySeeder;
use Database\Seeders\CountrySeeder;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
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

    public function testAnnouncerCreateComment()
    {
        $user = User::factory()->create([
            'role_id' => User::ROLE_ANNOUNCER,
            'id' => 2
        ]);

        $this->be($user);

        Conference::factory()->create();
        $report = Report::factory()->create();

        $this->post(route('comments.store', [
            'report_id' => $report->id,
            'text' => 'test conf',
            'first_name' => 'Test',
            'last_name' => 'LastName',
        ]))->assertRedirect(route('report.home', ['report' => $report->id]));

        $this->assertDatabaseHas('comments', [
            'creator_id' => $user->id,
            'report_id' => $report->id,
            'text' => 'test conf',
            'first_name' => 'Test',
            'last_name' => 'LastName',
        ]);

    }

    public function testListenerCreateComment()
    {
        $user = User::factory()->create([
            'role_id' => User::ROLE_LISTENER,
            'id' => 2
        ]);

        $this->be($user);

        Conference::factory()->create();
        $report = Report::factory()->create();

        $this->post(route('comments.store', [
            'report_id' => $report->id,
            'text' => 'test conf',
            'first_name' => 'Test',
            'last_name' => 'LastName',
        ]))->assertRedirect(route('report.home', ['report' => $report->id]));

        $this->assertDatabaseHas('comments', [
            'creator_id' => $user->id,
            'report_id' => $report->id,
            'text' => 'test conf',
            'first_name' => 'Test',
            'last_name' => 'LastName',
        ]);

    }

    public function testGuestCreateComment()
    {
        $this->post(route('comments.store', [
            'report_id' => 1,
            'text' => 'test conf',
            'first_name' => 'Test',
            'last_name' => 'LastName',
        ]))->assertRedirect(route('login'));

        $this->assertDatabaseMissing('comments', [
            'creator_id' => 1,
            'report_id' => 1,
            'text' => 'test conf',
            'first_name' => 'Test',
            'last_name' => 'LastName',
        ]);
    }

    public function testCreatorUpdateComment()
    {
        $user = User::factory()->create(['id' => 2]);

        $this->be($user);

        Conference::factory()->create();
        $report = Report::factory()->create(['id' => 1]);
        $comment = Comment::factory()->create([
            'id' => 7,
            'report_id' => 1,
            'text' => 'Test text',
            'first_name' => 'Name',
            'last_name' => 'Surname',
        ]);

        $this->post(route('comments.update', [
            'comment' => 7,
            'report_id' => 1,
            'text' => 'Updated text',
            'first_name' => 'Name',
            'last_name' => 'Surname',
        ]))->assertRedirect(route('report.home', ['report' => $report->id]));

        $this->assertDatabaseHas('comments', [
            'id' => 7,
            'text' => 'Updated text'
        ]);
    }

    public function testAdminUpdateComment()
    {
        $user = User::factory()->create([
            'role_id' => User::ROLE_ADMIN,
            'id' => 2
        ]);

        $this->be($user);

        Conference::factory()->create();
        $report = Report::factory()->create(['id' => 1]);
        $comment = Comment::factory()->create([
            'id' => 7,
            'report_id' => 1,
            'text' => 'Test text',
            'first_name' => 'Name',
            'last_name' => 'Surname',
        ]);

        $this->post(route('comments.update', [
            'comment' => 7,
            'report_id' => 1,
            'text' => 'Updated text',
            'first_name' => 'Name',
            'last_name' => 'Surname',
        ]))->assertRedirect(route('report.home', ['report' => $report->id]));

        $this->assertDatabaseHas('comments', [
            'id' => 7,
            'text' => 'Updated text'
        ]);
    }

}

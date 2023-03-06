<?php

namespace Tests\Feature\Category;

use App\Models\Category;
use App\Models\User;
use Database\Seeders\CountrySeeder;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function afterRefreshingDatabase()
    {
        $this->seed([
            RoleSeeder::class,
            CountrySeeder::class,
        ]);
    }

    public function testAdminCreateCategory()
    {
        $user = User::factory()->create(['role_id' => User::ROLE_ADMIN]);

        $this->be($user);

        $this->post(route('categories.store', [
            'id' => 1,
            'title' => 'Test Parent Category',
        ]));

        $this->post(route('categories.store', [
            'title' => 'Test Child Category',
            'parent_category_id' => 1,
        ]));

        $this->assertDatabaseHas('categories', [
            'title' => 'Test Parent Category'
        ]);

        $this->assertDatabaseHas('categories', [
            'title' => 'Test Child Category',
            'parent_category_id' => 1
        ]);
    }

    public function testGuestCreateCategory()
    {
        $this->get(route('categories.store', [
            'title' => 'Test Parent Category Guest',
        ]));

        $this->assertDatabaseMissing('categories', [
            'title' => 'Test Parent Category Guest',
        ]);
    }

    public function testAdminUpdateCategory()
    {
        $user = User::factory()->create(['role_id' => User::ROLE_ADMIN]);

        Category::factory()->create([
            'id' => 1,
            'title' => 'Test Parent Category'
        ]);
        Category::factory()->create([
            'id' => 2,
            'title' => 'Test Child Category',
            'parent_category_id' => 1,
        ]);

        $this->be($user);

        $this->post(route('categories.update', [
            'category' => 1,
            'title' => 'Parent Category Updated',
        ]));

        $this->post(route('categories.update', [
            'category' => 2,
            'title' => 'Child Category Updated',
            'parent_category_id' => 1,
        ]));

        $this->assertDatabaseHas('categories', [
            'title' => 'Parent Category Updated'
        ]);

        $this->assertDatabaseHas('categories', [
            'title' => 'Child Category Updated',
            'parent_category_id' => 1
        ]);

    }

    public function testGuestUpdateCategory()
    {
        $this->post(route('categories.update', [
            'category' => 1,
            'title' => 'Parent Category Updated',
        ]))->assertRedirect(route('login'));

        $this->post(route('categories.update', [
            'category' => 2,
            'title' => 'Child Category Updated',
            'parent_category_id' => 1,
        ]))->assertRedirect(route('login'));

        $this->assertDatabaseMissing('categories', [
            'title' => 'Parent Category Updated'
        ]);

        $this->assertDatabaseMissing('categories', [
            'title' => 'Child Category Updated',
            'parent_category_id' => 1
        ]);
    }


}

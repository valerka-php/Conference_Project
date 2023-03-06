<?php

namespace Tests\Feature\Plan;

use App\Events\PaymentSucceededEvent;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;
use Database\Seeders\CountrySeeder;
use Database\Seeders\PlanSeeder;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Mockery;
use Stripe\Customer;
use Stripe\PaymentMethod;
use Tests\TestCase;

class PlanTest extends TestCase
{
    use RefreshDatabase;

    public function afterRefreshingDatabase()
    {
        $this->seed([
            RoleSeeder::class,
            CountrySeeder::class,
            PlanSeeder::class,
        ]);
    }

    public function testChoiceNewPlan()
    {
        $this->withExceptionHandling();

        $user = User::factory()->create();
        $plan = Plan::where('name','free')->first();

        $this->be($user)->get(route('subscription.create', ['plan' => $plan->id]))->assertRedirect();
    }

    public function testCreateNewSubscription()
    {
        $user = User::factory()->create();

        $mock = Mockery::mock(User::class);

        $this->be($mock)->get(route('subscription.create', ['plan' => 2]));

        $mock->shouldReceive('newSubscription')
            ->with('test_sub', 'test_id')
            ->andReturn(Subscription::factory()->create(['user_id' => $user->id]));

        $mock->shouldReceive('checkout')->andReturn(true);

        $this->assertDatabaseHas('subscriptions', [
            'name' => 'test_sub'
        ]);
    }

    public function testUpdateDefaultPaymentMethod()
    {
        $this->withExceptionHandling();

        $user = User::factory()->create(['firstname' => "Test"]);

        $this->assertDatabaseHas('users', [
            'firstname' => 'Test',
            'pm_type' => null,
        ]);

        $userMock = Mockery::mock(User::class);
        $customerMock = Mockery::mock(Customer::class);
        $paymentMock = Mockery::mock(PaymentMethod::class);

        $this->json(
            'POST',
            '/stripe/webhook',
            ['type' => 'customer.subscription.updated', 'data' => ['object' => [
                'customer' => ['id' => 'test'],
                'default_payment_method' => ['id' => 'test']
            ]]],
        );

        $customerMock->shouldReceive('retrieve')->andReturn(true);
        $paymentMock->shouldReceive('retrieve')->andReturn(true);

        $userMock->shouldReceive('updateDefaultPaymentMethod')->andReturn(
            DB::table('users')->where('firstname', '=', $user->firstname)->update([
                'pm_type' => '4477'
            ])
        );

        $this->assertDatabaseHas('users', [
            'firstname' => 'Test',
            'pm_type' => '4477'
        ]);

    }
}

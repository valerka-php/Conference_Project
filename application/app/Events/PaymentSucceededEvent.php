<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Laravel\Cashier\Events\WebhookReceived;
use Stripe\Customer;
use Stripe\PaymentMethod;
use Stripe\Stripe;
use Symfony\Component\HttpFoundation\Response;

class PaymentSucceededEvent
{
    /**
     * Handle received Stripe webhooks.
     *
     * @param \Laravel\Cashier\Events\WebhookReceived $event
     * @return void
     */
    public function handle(WebhookReceived $event)
    {
        Stripe::setApiKey(config('stripe.secret'));

        if ($event->payload['type'] === 'customer.subscription.updated') {
            $customer = Customer::retrieve($event->payload['data']['object']['customer']);
            $paymentMethod = PaymentMethod::retrieve($event->payload['data']['object']['default_payment_method'], []);

            $user = User::where('email', $customer['email'])->first();
            $user->updateDefaultPaymentMethod($paymentMethod);
        }
    }
}

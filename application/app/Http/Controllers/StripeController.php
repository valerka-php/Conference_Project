<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;

class StripeController extends Controller
{
    public function index(Request $request)
    {
        return inertia('Plan/Show', [
            'plans' => Plan::all(),
            'subscriptions' => auth()->user()->subscriptions->toArray(),
            'message' => $request->input('message'),
        ]);
    }

    public function subscription(Plan $plan, Request $request)
    {
        return $request->user()->newSubscription($plan->name, $plan->stripe_plan)->checkout();
    }

    public function cancel(Request $request)
    {
        $request->user()->subscription($request->plan)->cancelNow();

        return redirect()
            ->route('home')
            ->with(['message' => __('subscription.cancel', ['plan' => $request->plan])]);
    }
}

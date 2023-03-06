<?php

namespace App\Http\Middleware;

use App\Models\Conference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     *
     * @param \Illuminate\Http\Request $request
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @param \Illuminate\Http\Request $request
     * @return mixed[]
     */
    public function share(Request $request)
    {
        return array_merge(parent::share($request), [
            'flash' => [
                'message' => session('message'),
            ],
            'guest' => [
                'user' => !$request->user(),
            ],
            'auth' => [
                'user' => $request->user(),
                'isListener' => $request->user() ? $request->user()->isListener() : false,
                'isAnnouncer' => $request->user() ? $request->user()->isAnnouncer() : false,
                'canCreate' => $request->user() ? $request->user()->can('create', Conference::class) : false,
                'favoriteReport' => $request->user() ? $request->user()->getIdFavoriteReports() : false,
            ],
            'ziggy' => function () use ($request) {
                return array_merge((new Ziggy)->toArray(), [
                    'location' => $request->url(),
                ]);
            },
        ]);
    }
}

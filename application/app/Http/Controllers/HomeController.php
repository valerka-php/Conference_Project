<?php

namespace App\Http\Controllers;

use App\Http\Filters\ConferenceFilter;
use App\Http\Requests\Conference\FilterRequest;
use App\Models\Category;
use App\Models\Conference;
use App\Models\Report;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class HomeController extends Controller
{
    public function index(FilterRequest $request, User $user)
    {
        $acceptedConferences = [];
        $userReports = [];
        $unavailableConferenceId = [];
        $remainingConferences = '';

        if (Auth::user()) {
            $acceptedConferences = $user->getIdAllConferences();
            $authUser = auth()->user();
            $userReports = $authUser->reports->toArray();
            $conference = Conference::first();
            $remainingConferences = $authUser->getRemainingConnectToConferences();

            if ($conference) {
                $unavailableConferenceId = $conference->getUnavailableConferenceId();
            }
        }

        $filter = app()->make(ConferenceFilter::class, ['queryParams' => array_filter($request->input())]);

        return inertia('Welcome', [
            'maxDate' => Conference::select('date')->orderBy('date', 'desc')->first()->date,
            'minDate' => Conference::select('date')->orderBy('date', 'asc')->first()->date,
            'maxReport' => Report::getMaxCount(),
            'categories' => Category::all('title', 'id'),
            'paginatedConferences' => Conference::filter($filter)->with('reports')->paginate(10)->withQueryString(),
            'unavailableConference' => $unavailableConferenceId,
            'allConferences' => Conference::all(),
            'acceptedConferences' => $acceptedConferences,
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'shareText' => config('app.share_text'),
            'shareUrl' => config('app.share_url'),
            'userReports' => $userReports,
            'paymentSuccess' => $request->input('checkout'),
            'remainingConferences' => $remainingConferences,
        ]);
    }
}

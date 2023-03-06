<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Conference;
use Illuminate\Support\Facades\Auth;

class ConferenceCategoryController extends Controller
{
    public function index(Category $category)
    {
        $userReports = [];
        $unavailableConferenceId = [];

        if (Auth::user()) {
            $authUser = auth()->user();
            $userReports = $authUser->reports->toArray();
            $conference = Conference::first();
            if ($conference) {
                $unavailableConferenceId = $conference->getUnavailableConferenceId();
            }
        }

        return inertia('Conference/Categories', [
            'paginatedConferences' => Conference::where('category_id', $category->id)->paginate(8),
            'unavailableConference' => $unavailableConferenceId,
            'shareText' => config('app.share_text'),
            'shareUrl' => config('app.share_url'),
            'userReports' => $userReports,
        ]);
    }
}

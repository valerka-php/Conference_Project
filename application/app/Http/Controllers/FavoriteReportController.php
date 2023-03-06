<?php

namespace App\Http\Controllers;

use App\Models\User;

class FavoriteReportController extends Controller
{
    public function index(User $user)
    {
        return inertia('Report/ShowReports', [
            'reports' => $user->favoriteReports->toArray(),
        ]);
    }
}

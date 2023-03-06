<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\UserFavoriteReport;
use Illuminate\Http\Request;

class UserFavoriteReportController extends Controller
{
    public function store(Request $request, Report $report)
    {
        $report->addToFavorites();
        return back()->with('message', __('favoriteReport.added', ['report' => $report->title]));
    }

    public function delete(Request $request, Report $report)
    {
        $report->removeFromFavorites();
        return back()->with('message', __('favoriteReport.removed', ['report' => $report->title]));
    }
}

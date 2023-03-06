<?php

namespace App\Http\Controllers;

use App\Http\Requests\Search\SearchRequest;
use App\Models\Conference;
use App\Models\Report;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class SearchController extends Controller
{
    public function index(SearchRequest $request)
    {
        $checkbox = $request->validated("checkbox");
        $currentDate = Carbon::now()->timezone('Europe/Kiev')->format('Y-m-d');
        $conferences = [];
        $reports = [];

        if (key_exists('conference', $checkbox) && $request->validated('checkbox')) {
            $conferences = Conference::select('id', 'title')
                ->where('title', 'LIKE', '%' . $request->title . '%')
                ->where('date', '>=', $currentDate)
                ->get();
        }

        if (key_exists('report', $checkbox) && $request->validated('checkbox')) {
            $conferencesReport = Conference::where('date', '>=', $currentDate)->get();

            foreach ($conferencesReport as $conference) {
                if ($conference->date > $currentDate) {
                    $reports = array_merge(
                        $reports,
                        $conference->reportsWhereLike($request->title)
                    );
                } elseif ($conference->date == $currentDate) {
                    $reports = array_merge(
                        $reports,
                        $conference->reportsWhereLikeTime($request->title)
                    );
                }
            }
        }

        return inertia('Search/ShowResult', [
            'conferences' => $conferences,
            'reports' => $reports,
        ]);
    }
}

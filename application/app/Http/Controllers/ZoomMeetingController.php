<?php

namespace App\Http\Controllers;

use App\Http\Requests\ZoomLinksShowRequest;
use App\Models\Report;
use App\Services\ZoomMeetingsService;
use Illuminate\Support\Facades\Cache;

class ZoomMeetingController extends Controller
{
    public function index(ZoomLinksShowRequest $request, ZoomMeetingsService $meetings)
    {
        $reports = Report::getAllWithZoomLinks($meetings->getAll());

        return inertia('Zoom/Meetings', [
            'zoomReports' => $reports->paginate(10)
        ]);
    }
}

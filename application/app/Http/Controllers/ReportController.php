<?php

namespace App\Http\Controllers;

use App\Http\Filters\ReportFilter;
use App\Http\Requests\Report\CreateRequest;
use App\Http\Requests\Report\DeleteRequest;
use App\Http\Requests\Report\EditRequest;
use App\Http\Requests\Report\FilterRequest;
use App\Http\Requests\Report\IndexRequest;
use App\Http\Requests\Report\LeaveRequest;
use App\Http\Requests\Report\StoreRequest;
use App\Http\Requests\Report\UpdateRequest;
use App\Jobs\CreateZoomLinkJob;
use App\Jobs\DeleteReportJob;
use App\Jobs\NewReportJob;
use App\Jobs\UpdateTimeReportJob;
use App\Models\Category;
use App\Models\Conference;
use App\Models\Report;
use Http\Discovery\Exception;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(IndexRequest $request, Report $report)
    {
        return inertia('Report/ShowReport', [
            'report' => $report->toArray(),
            'isCreator' => $request->user()->can('update', $report),
            'breadcrumbs' => get_breadcrumbs($report->category_id)
        ]);
    }

    public function show(FilterRequest $request, Conference $conference)
    {
        $filter = app()->make(ReportFilter::class, ['queryParams' => array_filter($request->input())]);

        return inertia('Report/ShowReports', [
            'reports' => Report::filter($filter)
                ->where('conference_id', $conference->id)
                ->withCount('comments')
                ->paginate(10)
                ->withQueryString(),
            'conference' => $conference,
            'acceptedConference' => $conference->accepted(),
            'categories' => Category::select('title', 'id')->get(),
        ]);
    }

    public function create(CreateRequest $request, Conference $conference)
    {
        return inertia('Report/CreateReport', [
            'categories' => Category::all(),
            'conferenceId' => $conference->id,
            'date' => $conference->date,
        ]);
    }

    public function store(StoreRequest $request, Report $report, Conference $conference)
    {
        $availableTime = check_time($conference->getNotAvailableTime(), $request->start_time, $request->end_time);

        if ($availableTime === true) {

            $validated = $request->validated();
            $validated['creator_id'] = $request->user()->id;

            if ($request->file('file')){
                $file = $request->file('file');
                $filepath = $file[0]->store('presentations', ['disk' => 'public']);
                $validated['presentation'] = $filepath;
            }

            try {
                DB::transaction(function () use ($conference, &$report, $validated) {
                    $report = $report->create($validated);
                    $conference->join();
                });

                if ($request->online) {
                    CreateZoomLinkJob::dispatch($report, $conference);
                }

                NewReportJob::dispatch($report, auth()->user());
            } catch (Exception $e) {
                return redirect()->route('home')->with('message', $e->getMessage());
            }

            return redirect()->route('home')->with('message', __('report.created'));
        }

        return back()->withErrors(['time' => ["$availableTime"]]);
    }

    public function edit(EditRequest $request, Report $report)
    {
        return inertia('Report/EditReport', [
            'report' => $report->toArray(),
            'categories' => Category::all(),
        ]);
    }

    public function update(UpdateRequest $request, Report $report, Conference $conference)
    {
        $availableTime = check_time($conference->getNotAvailableTime(), $request->start_time, $request->end_time);

        if ($availableTime === true || compare_time($request->input(), $report->toArray())) {

            $validated = $request->validated();

            if ($request->file()) {
                $file = $request->file('file');
                $filepath = $file[0]->store('presentations');
                $validated['presentation'] = $filepath;
            }

            try {
                $report->updateOne($request->validated());

                if (!compare_time($request->input(), $report->toArray())) {
                    foreach ($conference->users as $user) {
                        UpdateTimeReportJob::dispatch($report, $user->email);
                    }
                }
            } catch (\Exception $e) {
                return $e->getMessage();
            }

            return redirect()->route('report.home', ['report' => $report->id])->with('message', __('report.updated'));
        }

        return back()->withErrors(['time' => ["$availableTime"]]);
    }

    public function leave(LeaveRequest $request, Report $report)
    {
        $report->deleteAndLeaveConference();

        return back()->with('message', __('report.deleted'));
    }

    public function delete(DeleteRequest $request, Report $report)
    {
        try {
            $report->deleteAndLeaveConference();

            DeleteReportJob::dispatch($report->conference, $report->creator->email);
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        return redirect()->route('home')->with('message', __('report.deleted'));
    }
}

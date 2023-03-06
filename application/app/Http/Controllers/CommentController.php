<?php

namespace App\Http\Controllers;

use App\Http\Requests\Comment\EditRequest;
use App\Http\Requests\Comment\StoreRequest;
use App\Http\Requests\Comment\UpdateRequest;
use App\Jobs\NewCommentJob;
use App\Mail\NewCommentInReportMail;
use App\Models\Comment;
use App\Models\Report;
use Illuminate\Support\Facades\Mail;

class CommentController extends Controller
{
    public function index(Report $report)
    {
        $comments = Comment::offset(request('offset'))->where('report_id', $report->id)->take(7)->get();
        return response()->json($comments);
    }

    public function create(Report $report)
    {
        return inertia('Report/Comment/CreateComment', [
            'report' => $report->toArray(),
            'firstName' => auth()->user()->firstname,
            'lastName' => auth()->user()->lastname,
        ]);
    }

    public function store(StoreRequest $request, Comment $comment)
    {
        $validated = $request->validated();
        $validated['creator_id'] = auth()->user()->id;

        try {
            $comment->create($validated);

            $report = Report::find($request->validated('report_id'));

            NewCommentJob::dispatch($report, auth()->user());
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        return redirect()->route('report.home', [
            'report' => $request->report_id
        ])->with('message', __('comment.created'));
    }

    public function edit(EditRequest $request, Comment $comment, Report $report)
    {
        if ($comment->expiredTime()) {
            return abort(404);
        }

        return inertia('Report/Comment/EditComment', [
            'commentId' => $comment->id,
            'text' => $comment->text,
            'report' => $report->toArray(),
            'firstName' => auth()->user()->firstname,
            'lastName' => auth()->user()->lastname,
            'isCreator' => $report->id === auth()->user()->id || auth()->user()->isAdmin(),
        ]);
    }

    public function update(UpdateRequest $request, Comment $comment)
    {
        $validated = $request->validated();
        $validated['creator_id'] = auth()->user()->id;

        $comment->update($validated);

        return redirect()->route('report.home', [
            'report' => $request->report_id
        ])->with('message', __('comment.updated'));
    }
}

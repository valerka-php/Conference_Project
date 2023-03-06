<?php

namespace App\Http\Controllers;

use App\Http\Requests\Conference\CreateRequest;
use App\Http\Requests\Conference\DeleteRequest;
use App\Http\Requests\Conference\EditRequest;
use App\Http\Requests\Conference\JoinRequest;
use App\Http\Requests\Conference\LeaveRequest;
use App\Http\Requests\Conference\ShowRequest;
use App\Http\Requests\Conference\StoreRequest;
use App\Http\Requests\Conference\UpdateRequest;
use App\Jobs\DeleteConferenceJob;
use App\Jobs\NewListenerConferenceJob;
use App\Models\Category;
use App\Models\Conference;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\Country;

class ConferenceController extends Controller
{
    public function create(CreateRequest $request, Country $countries)
    {
        return inertia('Conference/Create', [
            'categories' => Category::all(),
            'countries' => $countries->all('name'),
            'userId' => $request->user()->id,
            'mapId' => config('app.google_map_id')
        ]);
    }

    public function store(StoreRequest $request, Conference $conference)
    {
        $conference->create($request->validated());
        return redirect()->route('home')->with('message', __('conference.created'));
    }

    public function edit(EditRequest $request, Conference $conference, Country $countries)
    {
        return inertia('Conference/Edit', [
            'conference' => $conference->find($conference->id),
            'countries' => $countries->all('name'),
            'categories' => Category::all(),
        ]);
    }

    public function update(UpdateRequest $request, Conference $conference)
    {
        $conference->updateOne($request->validated());
        return redirect()
            ->route('conferences.show', ['conference' => $conference->id])
            ->with('message', __('conference.updated'));
    }

    public function show(ShowRequest $request, Conference $conference, User $user)
    {
        return inertia('Conference/Conference', [
            'breadcrumbs' => get_breadcrumbs($conference->category_id),
            'conference' => $conference->find($conference->id),
            'canLeave' => $user->canLeave($conference->id),
            'mapId' => config('app.google_map_id'),
            'shareText' => config('app.share_text'),
            'shareUrl' => config('app.share_url'),
        ]);
    }

    public function delete(DeleteRequest $request, Conference $conference)
    {
        try {
            DB::transaction(function () use ($conference) {
                $conference->delete();
                $conference->unsubscribeUsers();
            });

            DeleteConferenceJob::dispatch($conference->creator->email, $conference->title);
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        return redirect()->route('home')->with('message', __('conference.deleted'));
    }

    public function join(JoinRequest $request, Conference $conference)
    {
        try {
            $conference->join();

            if (auth()->user()->isListener()) {
                foreach ($conference->announcers as $announcer) {
                    NewListenerConferenceJob::dispatch($conference, auth()->user(), $announcer->email);
                }
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        return back()->with('message', __('conference.joined', ['conference' => $conference->title]));
    }

    public function leave(LeaveRequest $request, User $user, Conference $conference)
    {
        $user->leaveConference($conference->id);

        return back()->with('message', __('conference.left', ['conference' => $conference->title]));
    }
}



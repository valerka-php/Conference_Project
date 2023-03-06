<?php

namespace App\Jobs;

use App\Models\Conference;
use App\Models\Report;
use App\Services\ZoomMeetingsService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class CreateZoomLinkJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Report $report;
    private Conference $conference;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Report $report, Conference $conference)
    {
        $this->report = $report;
        $this->conference = $conference;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $response = (new ZoomMeetingsService)->create([
            'topic' => $this->report->title,
            'agenda' => $this->report->description,
            'start_time' => $this->conference->date . 'T' . $this->report->start_time,
            'duration' => get_report_duration($this->conference->date, $this->report->start_time, $this->report->end_time),
        ]);

        $this->report->update([
            'zoom_id' => $response['data']['id'],
            'start_url' => $response['data']['start_url'],
            'join_url' => $response['data']['join_url'],
            'duration' => $response['data']['duration'],
            'online' => true,
        ]);

        Cache::forget('zoom-links');
    }
}

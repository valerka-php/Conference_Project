<?php

namespace App\Jobs;

use App\Exports\CommentExport;
use App\Models\Report;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;

class ExportCommentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Report $report;
    protected string $fileName;

    /**
     * Create a new job instance.
     * @return void
     */
    public function __construct(Report $report, string $fileName)
    {
        $this->report = $report;
        $this->fileName = $fileName;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        Excel::store(new CommentExport($this->report), $this->fileName, 'public');
    }
}

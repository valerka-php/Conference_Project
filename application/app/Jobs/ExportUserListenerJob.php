<?php

namespace App\Jobs;

use App\Exports\ListenerExport;
use App\Models\Conference;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;

class ExportUserListenerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Conference $conference;
    protected string $fileName;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Conference $conference, string $fileName)
    {
        $this->conference = $conference;
        $this->fileName = $fileName;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Excel::store(new ListenerExport($this->conference), $this->fileName, 'public');
    }
}

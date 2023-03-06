<?php

namespace App\Jobs;

use App\Mail\DeleteReportMail;
use App\Models\Conference;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class DeleteReportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Conference $conference;
    private string $email;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Conference $conference, string $email)
    {
        $this->conference = $conference;
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->email)->send(new DeleteReportMail($this->conference));
    }
}

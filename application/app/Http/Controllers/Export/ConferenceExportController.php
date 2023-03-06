<?php

namespace App\Http\Controllers\Export;

use App\Events\ConferenceExportDone;
use App\Http\Controllers\Controller;
use App\Http\Requests\Export\CsvRequest;
use App\Jobs\ExportConferenceJob;

class ConferenceExportController extends Controller
{
    public function csv(CsvRequest $request)
    {
        $fileName = 'conferences_' . date('Y_m_d_H_i_s') . '.csv';

        ExportConferenceJob::dispatch($fileName);

        broadcast(new ConferenceExportDone($fileName));
    }
}

<?php

namespace App\Http\Controllers\Export;

use App\Events\ReportExportDone;
use App\Http\Controllers\Controller;
use App\Http\Requests\Export\CsvRequest;
use App\Jobs\ExportReportJob;
use App\Models\Conference;

class ReportExportController extends Controller
{
    public function csv(CsvRequest $request, Conference $conference)
    {
        $fileName = 'reports_' . date('Y_m_d_H_i_s') . '.csv';

        ExportReportJob::dispatch($conference, $fileName);

        broadcast(new ReportExportDone($fileName));
    }
}

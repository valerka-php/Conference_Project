<?php

namespace App\Http\Controllers\Export;

use App\Events\CommentExportDone;
use App\Http\Controllers\Controller;
use App\Http\Requests\Export\CsvRequest;
use App\Jobs\ExportCommentJob;
use App\Models\Report;

class CommentExportController extends Controller
{
    public function csv(CsvRequest $request, Report $report)
    {
        $fileName = 'comments_' . date('Y_m_d_H_i_s') . '.csv';

        ExportCommentJob::dispatch($report, $fileName);

        broadcast(new CommentExportDone($fileName));
    }
}

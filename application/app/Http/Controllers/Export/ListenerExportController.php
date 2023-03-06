<?php

namespace App\Http\Controllers\Export;

use App\Events\UserListenerExportDone;
use App\Http\Controllers\Controller;
use App\Http\Requests\Export\CsvRequest;
use App\Jobs\ExportUserListenerJob;
use App\Models\Conference;

class ListenerExportController extends Controller
{
    public function csv(CsvRequest $request, Conference $conference)
    {
        $fileName = 'listeners_' . date('Y_m_d_H_i_s') . '.csv';

        ExportUserListenerJob::dispatch($conference, $fileName);

        broadcast(new UserListenerExportDone($fileName));
    }
}

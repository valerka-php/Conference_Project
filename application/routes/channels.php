<?php

use App\Broadcasting\CommentExportChannel;
use App\Broadcasting\ConferenceExportChannel;
use App\Broadcasting\ReportExportChannel;
use App\Broadcasting\UserListenerExportChannel;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('export-comments', CommentExportChannel::class);
Broadcast::channel('export-conference', ConferenceExportChannel::class);
Broadcast::channel('export-reports', ReportExportChannel::class);
Broadcast::channel('export-user-listener', UserListenerExportChannel::class);

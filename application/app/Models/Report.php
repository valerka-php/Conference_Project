<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\MessageBag;
use Illuminate\Validation\ValidationException;


class Report extends Model
{
    use HasFactory;
    use Filterable;

    protected $table = 'reports';

    protected $fillable = [
        'creator_id',
        'conference_id',
        'title',
        'description',
        'presentation',
        'start_time',
        'end_time',
        'category_id',
        'zoom_id',
        'start_url',
        'join_url',
        'duration',
        'online',
    ];

    private static function validationError($message)
    {
        $messageBag = new MessageBag;
        $messageBag->add('time', __($message));

        throw ValidationException::withMessages($messageBag->getMessages());
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($report) {
            static::availableTime($report);
        });

        static::updating(function ($report) {
            static::availableTime($report);
        });
    }

    public static function availableTime($report):string|bool
    {
        $conference = Conference::find($report->conference_id);
        $start = $report->start_time;
        $end = $report->end_time;

        $availableTime = check_time($conference->getNotAvailableTime(), $start, $end);

        if ($availableTime !== true) {
            return self::validationError("$availableTime");
        }

        return true;
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function conference()
    {
        return $this->belongsTo(Conference::class, 'conference_id');
    }

    public function updateOne(array $data): void
    {
        Report::where('id', $this->id)->update($data);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function deleteAndLeaveConference(): void
    {
        DB::transaction(function () {
            $creator = $this->creator;
            $creator->leaveConference($this->conference_id);

            $this->delete();
        });
    }

    public function addToFavorites(): void
    {
        UserFavoriteReport::create([
            'user_id' => auth()->user()->id,
            'report_id' => $this->id
        ]);
    }

    public function removeFromFavorites(): void
    {
        UserFavoriteReport::where('user_id', auth()->user()->id)->where('report_id', $this->id)->delete();
    }

    public static function getMaxCount(): int
    {
        return self::select('conference_id', self::raw('count(*) as total'))
            ->groupBy('conference_id')
            ->orderBy('total', 'desc')
            ->first()->total;
    }

    public static function getAllWithZoomLinks(array $links): Collection
    {
        $reports = self::where('online', '=', true)->get();

        foreach ($reports as $report) {
            foreach ($links['data']['meetings'] as $meeting) {
                if (in_array($report->zoom_id, $meeting)) {
                    $report->zoom_uuid = $meeting['uuid'];
                    $report->zoom_host_id = $meeting['host_id'];
                    $report->zoom_topic = $meeting['topic'];
                    $report->zoom_type = $meeting['type'];
                    $report->zoom_start_time = $meeting['start_time'];
                    $report->zoom_timezone = $meeting['timezone'];
                    $report->zoom_created_at = $meeting['created_at'];
                }
            }
        }

        return $reports;
    }
}

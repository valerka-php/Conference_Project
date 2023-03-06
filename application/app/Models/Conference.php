<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Conference extends Model
{
    const AVAILABLE_BOOKING_TIME_INTERVAL = 52;

    const ROLE_ANNOUNCER = 2;

    use HasFactory;
    use Filterable;

    protected $table = 'conferences';

    protected $fillable = [
        'creator_id',
        'title',
        'date',
        'latitude',
        'longitude',
        'country',
        'category_id'
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function reportsWhereLike(string $title): array
    {
        return $this->hasMany(Report::class)
            ->where('title', 'LIKE', '%' . $title . '%')
            ->get()
            ->toArray();
    }

    public function reportsWhereLikeTime(string $title): array
    {
        $currentTime = Carbon::now()->timezone('Europe/Kiev')->format('H:i:s');

        return $this->hasMany(Report::class)
            ->where('title', 'LIKE', '%' . $title . '%')
            ->where('start_time', '>=', $currentTime)
            ->get()
            ->toArray();
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_conference');
    }

    public function announcers()
    {
        return $this->belongsToMany(User::class, 'user_conference')
            ->where('role_id', self::ROLE_ANNOUNCER);
    }

    public function unsubscribeUsers(): void
    {
        $subscribedUsers = UserHasConference::where('conference_id', $this->id);
        $subscribedUsers->delete();
    }

    protected static function booting(): void
    {
        static::creating(function ($conference) {
            $conference->creator_id = Auth::id();
        });
    }

    public function join(): void
    {
        UserHasConference::insert([
            'user_id' => Auth::user()->id,
            'conference_id' => $this->id
        ]);
    }

    public function updateOne(array $data): void
    {
        Conference::where('id', $this->id)->update($data);
    }

    public function getNotAvailableTime(): array
    {
        $unavailableTime = [];

        $reports = $this->reports->toArray();

        if ($reports) {
            foreach ($reports as $report) {
                $startTime = Carbon::create($report['start_time']);
                $endTime = Carbon::create($report['end_time']);

                while ($startTime->format('H:i:s') !== $endTime->format('H:i:s')) {
                    $unavailableTime[] .= $startTime->format('H:i:s');
                    $startTime->addMinute(15);
                }
            }

            $unavailableTime = array_unique($unavailableTime);
            sort($unavailableTime);
        }

        return $unavailableTime;
    }

    public function getUnavailableConferenceId(): array
    {
        $result = [];

        foreach (Conference::all() as $conference) {
            if (count($conference->getNotAvailableTime()) >= self::AVAILABLE_BOOKING_TIME_INTERVAL) {
                $result[] = $conference->id;
            }
        }

        return $result;
    }

    public function accepted()
    {
        return UserHasConference::where('user_id', auth()->user()->id)->where('conference_id', $this->id)->exists();
    }
}

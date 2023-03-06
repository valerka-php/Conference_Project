<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Cashier\Subscription;
use Laravel\Sanctum\HasApiTokens;
use Package\Country\Country;
use Laravel\Cashier\Billable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Billable;

    const ROLE_ANNOUNCER = 2;
    const ROLE_LISTENER = 1;
    const ROLE_ADMIN = 3;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'role_id',
        'birthdate',
        'country_id',
        'email',
        'phone',
        'password'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'birthdate' => 'date'
    ];

    public function conferences(): BelongsToMany
    {
        return $this->belongsToMany(Conference::class, 'user_conference');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function reports()
    {
        return $this->hasMany(Report::class, 'creator_id', 'id');
    }

    public function favoriteReports()
    {
        return $this->belongsToMany(Report::class, 'users_favorite_reports');
    }

    public function canLeave(int $conferenceId)
    {
        $id = [];

        foreach (Auth::user()->conferences()->get()->toArray() as $conference) {
            $id[] = $conference['id'];
        }

        return in_array($conferenceId, $id);
    }

    public function leaveConference(int $conferenceId): void
    {
        $userHasConference = UserHasConference::where('user_id', Auth::user()->id)->where('conference_id', $conferenceId);
        $userHasConference->delete();
    }

    public function getIdFavoriteReports()
    {
        $result = [];

        $reports = auth()->user()->favoriteReports->toArray();

        foreach ($reports as $report) {
            $result[] = $report['id'];
        }

        return $result;
    }

    public function getIdAllConferences(): array
    {
        $result = [];

        $user = $this->find(Auth::user()->id);
        $conferences = $user->conferences()->get()->toArray();

        foreach ($conferences as $conference) {
            $result[] = $conference['id'];
        }

        return $result;
    }

    public function isAdmin(): bool
    {
        return $this->role_id == self::ROLE_ADMIN;
    }

    public function isAnnouncer(): bool
    {
        return $this->role_id == self::ROLE_ANNOUNCER;
    }

    public function isListener(): bool
    {
        return $this->role_id == self::ROLE_LISTENER;
    }

    public static function getAnnouncers(): array
    {
        $announcers = self::where('role_id', self::ROLE_ANNOUNCER)->get();

        $result = [];

        foreach ($announcers as $announcer) {
            $result[$announcer->id] = $announcer->firstname . ' ' . $announcer->lastname;
        }

        return $result;
    }

    public function getRemainingConnectToConferences(): string
    {
        $subscriptions = Subscription::query()->where('user_id', $this->id)->active()->get();
        $plans = Plan::all();

        $result = 0;

        foreach ($subscriptions as $subscription) {
            if ($subscription->name === 'unlimited') {
                $result = $subscription->name;
                break;
            }
            foreach ($plans as $plan) {
                if ($subscription->name === $plan->name) {
                    $result += intval($plan->count_joins);
                }
            }
        }

        return $result;
    }
}

<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    const LIMIT_COMMENT_TIME_MINUTES = 10;

    protected $fillable = [
        'report_id',
        'creator_id',
        'first_name',
        'last_name',
        'text'
    ];

    public function report()
    {
        return $this->belongsTo(Report::class, 'report_id');
    }

    function expiredTime(): bool
    {
        $updatedAt = Carbon::create($this->updated_at);

        if ($updatedAt->diffInMinutes(Carbon::now()) > self::LIMIT_COMMENT_TIME_MINUTES) {
            return true;
        }

        return false;
    }
}

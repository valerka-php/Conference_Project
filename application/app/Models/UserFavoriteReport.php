<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserFavoriteReport extends Model
{
    use HasFactory;

    protected $table = 'users_favorite_reports';

    protected $fillable = [
        'user_id',
        'report_id'
    ];
}

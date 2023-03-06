<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $table = 'countries';

    public static function getAllNames(): array
    {
        $countries = self::all('id', 'name');
        $result = [];

        foreach ($countries as $country) {
            $result[$country['name']] = $country['name'];
        }

        return $result;
    }
}

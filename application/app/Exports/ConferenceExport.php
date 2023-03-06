<?php

namespace App\Exports;

use App\Models\Conference;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ConferenceExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        sleep(5);

        return Conference::select(
            'title',
            'date',
            'latitude',
            'longitude',
            'country'
        )
            ->withCount('reports')
            ->withCount('users')
            ->get();
    }

    public function headings(): array
    {
        return [
            'title',
            'date',
            'latitude',
            'longitude',
            'country',
            'reports',
            'users'
        ];
    }
}

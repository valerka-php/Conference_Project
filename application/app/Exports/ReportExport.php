<?php

namespace App\Exports;

use App\Models\Report;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReportExport implements FromCollection, WithHeadings
{
    protected int $conferenceId;

    /**
     * @return \Illuminate\Support\Collection
     */
    public function __construct(int $id)
    {
        $this->conferenceId = $id;
    }

    public function collection()
    {
        sleep(5);

        return Report::select(
            'title',
            'start_time',
            'end_time',
            'description',
        )
            ->withCount('comments')
            ->where('conference_id', $this->conferenceId)
            ->get();
    }

    public function headings(): array
    {
        return [
            'title',
            'start_time',
            'end_time',
            'description',
            'comments'
        ];
    }
}

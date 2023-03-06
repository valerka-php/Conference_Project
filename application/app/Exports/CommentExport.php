<?php

namespace App\Exports;

use App\Models\Report;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CommentExport implements FromCollection, WithHeadings
{
    protected Report $report;

    public function __construct(Report $report)
    {
        $this->report = $report;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $comments = $this->report->comments;

        $result = [];

        foreach ($comments as $comment) {
            $result[] = array(
                'user_info' => $comment->first_name . ' ' . $comment->last_name,
                'text' => $comment->text,
                'created_at' => $comment->created_at,
            );
        }

        sleep(5);

        return collect($result);
    }

    public function headings(): array
    {
        return [
            'user_info',
            'text',
            'created_at',
        ];
    }
}

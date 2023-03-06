<?php

namespace App\Http\Filters;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class ReportFilter extends AbstractFilter
{
    public const PERIOD_OF_TIME = 'period_of_time';
    public const CATEGORY_ID = 'category_id';
    public const CONFERENCE_ID = 'conference_id';
    public const REPORT_TIME = 'report_time';

    protected function getCallbacks(): array
    {
        return [
            self::PERIOD_OF_TIME => [$this, 'periodOfTime'],
            self::CATEGORY_ID => [$this, 'categoryId'],
            self::CONFERENCE_ID => [$this, 'conferenceId'],
            self::REPORT_TIME => [$this, 'reportTime'],
        ];
    }

    public function reportTime(Builder $builder, $value)
    {
        $currentTime = Carbon::now()->timezone('Europe/Kiev')->format('H:i:s');
        $builder->whereRaw("TIMEDIFF(end_time , start_time) = '$value'")
            ->where('start_time', '>=', $currentTime);
    }

    public function periodOfTime(Builder $builder, $value)
    {
        $builder->where('start_time', '>=', $value['start_time']);
        $builder->where('end_time', '<=', $value['end_time']);
    }

    public function categoryId(Builder $builder, $value)
    {
        $currentTime = Carbon::now()->timezone('Europe/Kiev')->format('H:i:s');
        $builder->whereIn('category_id', $value)->where('start_time', '>=', $currentTime);
    }

    public function conferenceId(Builder $builder, $value)
    {
        $builder->where('conference_id', $value);
    }
}

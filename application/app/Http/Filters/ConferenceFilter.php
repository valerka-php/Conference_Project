<?php

namespace App\Http\Filters;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class  ConferenceFilter extends AbstractFilter
{
    public const CATEGORY_ID = 'category_id';
    public const DATE = 'date';
    public const REPORT_COUNT = 'report_count';

    protected function getCallbacks(): array
    {
        return [
            self::CATEGORY_ID => [$this, 'categoryId'],
            self::DATE => [$this, 'date'],
            self::REPORT_COUNT => [$this, 'reportCount'],
        ];
    }

    public function date(Builder $builder, $value)
    {
        $builder->where('date', '>=', $value['min']);
        $builder->where('date', '<=', $value['max']);
    }

    public function categoryId(Builder $builder, $value)
    {
        $currentDate = Carbon::now()->timezone('Europe/Kiev')->format('Y-m-d');
        $builder->whereIn('category_id', $value)->where('date', '>=', $currentDate);
    }

    public function reportCount(Builder $builder, $value)
    {
        $minReportCount = $value[0];
        $maxReportCount = $value[1];

        $currentDate = Carbon::now()->timezone('Europe/Kiev')->format('Y-m-d');

        $builder->has('reports', '>=', $minReportCount)
            ->has('reports', '<=', $maxReportCount)
            ->where('date', '>=', $currentDate);
    }
}

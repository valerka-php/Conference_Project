<?php

use Carbon\Carbon;

function get_nearest_available_time(Carbon $startTime, Carbon $endTime, array $notAvailableTime): bool|string
{
    $currentStartTime = $startTime->format('H:i:s');
    $availableStartTime = $currentStartTime;

    foreach ($notAvailableTime as $time) {
        if ($startTime->format('H:i:s') == $time) {
            $startTime->addMinute(15);
            $availableStartTime = $startTime->format('H:i:s');
        }
    }

    $availableEndTime = $startTime->addMinute(15);

    for ($i = 0; $i < 3; $i++) {
        if (!in_array($availableEndTime->format('H:i:s'), $notAvailableTime)) {
            $availableEndTime->addMinute(15);
        }
    }

    $availableEndTime = $availableEndTime->format('H:i:s');
    $currentEndTime = $endTime->format('H:i:s');

    if ($currentEndTime <= $availableEndTime && $currentStartTime >= $availableStartTime || empty($notAvailableTime)) {
        $availableTime = true;
    } else {
        $availableTime = $availableStartTime . ' - ' . $availableEndTime;
        $availableTime = "Nearest available time:  $availableTime";
    }

    return $availableTime;
}

function check_time(array $notAvailableTime, string $start, string $end): bool|string
{
    $startReport = Carbon::create($start);
    $endReport = Carbon::create($end);

    if ($startReport->format('H:i:s') > $endReport->format('H:i:s')) {
        return 'Start time must be less then end time';
    }

    if ($startReport->diffInMinutes($endReport) > 60) {
        return 'Time must be less then 1 hour';
    }

    if ($startReport->diffInMinutes($endReport) < 15) {
        return 'Time must be 15 minutes or more';
    }

    return get_nearest_available_time($startReport, $endReport, $notAvailableTime);
}

function compare_time(array $currentTime, array $comparedTime): bool
{
    $currentStartTime = $currentTime['start_time'] . ':00';
    $currentEndTime = $currentTime['end_time'] . ':00';
    $comparedStartTime = $comparedTime['start_time'];
    $comparedEndTime = $comparedTime['end_time'];

    if ($currentStartTime == $comparedStartTime && $currentEndTime == $comparedEndTime) {
        return true;
    }
    return false;
}

function get_report_duration(string $date, string $startTime, string $endTime): int
{
    $startDate = explode('-',$date);
    $year = $startDate[0];
    $month = $startDate[1];
    $day = $startDate[2];

    $startTime = explode(':',$startTime);
    $startHour = $startTime[0];
    $startMinute = $startTime[1];

    $endTime = explode(':',$endTime);
    $endHour = $endTime[0];
    $endMinute = $endTime[1];

    $start = Carbon::create($year, $month, $day, $startHour, $startMinute);
    $end = Carbon::create($year, $month, $day, $endHour, $endMinute);

    return $start->diffInMinutes($end);
}

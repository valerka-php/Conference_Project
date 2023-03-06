<x-mail::message>
    # Introduction

    Добрый день, на конференцию {{ $report->title }} ( http://localhost:17000/conferences/{{ $report->conference->id }})
    присоединился новый участник {{ $user->firstname }} с докладом на тему (
    http://localhost:17000/reports/{{ $report->id }} ).

    Время доклада: {{ $report->start_time . ' - ' . $report->end_time }}

    Thanks,<br>
    {{ config('app.name') }}
</x-mail::message>

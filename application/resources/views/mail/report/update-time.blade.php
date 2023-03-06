<x-mail::message>
    # Introduction

    Добрый день, на конференции {{ $report->conference->title }}
    (http://localhost:17000/conferences/{{ $report->conference->id }})
    участник {{ $report->conference->creator->firstname }} с докладом на тему {{ $report->title }}
    (http://localhost:17000/report/{{ $report->id }} )

    перенес доклад на другое время

    Новое время доклада: {{ $report->start_time . ' - ' . $report->end_time }}

    Thanks,<br>
    {{ config('app.name') }}
</x-mail::message>

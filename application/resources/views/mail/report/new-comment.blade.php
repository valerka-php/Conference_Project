<x-mail::message>
    # Introduction

    Добрый день, на конференции {{ $report->conference->title }} ( http://localhost:17000/conferences/{{ $report->conference->id }} )
    пользователь{{ $user->firstname }} оставил комментарий на ваш доклад {{ $report->title }}( http://localhost:17000/report/{{ $report->id }} ).

    Thanks,
    {{ config('app.name') }}
</x-mail::message>

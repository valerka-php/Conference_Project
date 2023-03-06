<x-mail::message>
    # Introduction

    Добрый день, на конференции{{ $conference->title }} ( http://localhost:17000/conferences/{{ $conference->id }} )
    был удален ваш доклад администрацией.

    Thanks,
    {{ config('app.name') }}
</x-mail::message>

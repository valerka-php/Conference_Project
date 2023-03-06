<x-mail::message>
    # Introduction

    Добрый день, на конференцию {{ $conference->title }} ( http://localhost:17000/conferences/{{ $conference->id }} )
    присоединился новый слушатель {{ $user->firstname . ' ' . $user->lastname }}

    Thanks,
    {{ config('app.name') }}
</x-mail::message>

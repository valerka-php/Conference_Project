<?php

namespace App\Exports;

use App\Models\Conference;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ListenerExport implements FromCollection, WithHeadings
{
    const LISTENER_ID = 1;

    protected Conference $conference;

    public function __construct(Conference $conference)
    {
        $this->conference = $conference;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $users = $this->conference->users->where('role_id', self::LISTENER_ID);

        $result = [];

        foreach ($users as $user) {
            $result[] = array(
                'firstname' => $user->firstname,
                'lastname' => $user->lastname,
                'birthdate' => $user->birthdate,
                'country' => $user->country->name,
                'phone' => $user->phone,
                'email' => $user->email,
            );
        }

        sleep(5);

        return collect($result);
    }

    public function headings(): array
    {
        return [
            'firstname',
            'lastname',
            'birthdate',
            'country',
            'phone',
            'email',
        ];
    }
}

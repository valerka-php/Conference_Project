<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    protected $date = [
        ['Test', 'Listener', '12345678', '+22 (222) 222 22', '1', '227', '2018-12-05', 'test1@email.com',1],
        ['Test', 'Announcer', '12345678', '+22 (222) 222 222', '2', '227', '2018-12-05', 'test2@email.com',2],
        ['Test', 'Admin', '12345678', '+22 (222) 222 22', '3', '227', '2018-12-05', 'admin@groupbwt.com',3],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->date as $user) {
            DB::table('users')->insert([
                'id' => $user[8],
                'firstname' => $user[0],
                'lastname' => $user[1],
                'password' => Hash::make($user[2]),
                'phone' => $user[3],
                'role_id' => $user[4],
                'country_id' => $user[5],
                'birthdate' => $user[6],
                'email' => $user[7],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }

    }
}

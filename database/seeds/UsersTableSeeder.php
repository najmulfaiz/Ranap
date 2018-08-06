<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'Super Admin',
                'email' => 'super@ranap.com',
                'password' => Hash::make('super2018')
            ]
        ];

        foreach($users as $user) {
            User::create($user);
        }
    }
}

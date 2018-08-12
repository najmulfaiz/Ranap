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
                'password' => Hash::make('super2018'),
                'level' => 1
            ],
            [
                'name' => 'Pendaftaran',
                'email' => 'pendaftaran@ranap.com',
                'password' => Hash::make('pendaftaran2018'),
                'level' => 2
            ],
            [
                'name' => 'Ruang',
                'email' => 'ruang@ranap.com',
                'password' => Hash::make('ruang2018'),
                'level' => 3
            ],
            [
                'name' => 'Laboratorium',
                'email' => 'laboratorium@ranap.com',
                'password' => Hash::make('laboratorium2018'),
                'level' => 4
            ],
            [
                'name' => 'Apotek',
                'email' => 'apotek@ranap.com',
                'password' => Hash::make('apotek2018'),
                'level' => 5
            ],
            [
                'name' => 'Pembayaran',
                'email' => 'pembayaran@ranap.com',
                'password' => Hash::make('pembayaran2018'),
                'level' => 6
            ]
        ];

        foreach($users as $user) {
            User::create($user);
        }
    }
}

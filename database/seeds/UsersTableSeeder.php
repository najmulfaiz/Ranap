<?php

use Illuminate\Database\Seeder;

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
            'name' => 'Super Admin',
            'email' => 'super@ranap.com',
            'password' => Password::hash('super2018')
        ];
    }
}

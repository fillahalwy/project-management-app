<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'     => 'Atmin',
            'email'    => 'atmin@tester.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        User::create([
            'name'     => 'Member1',
            'email'    => 'member1@tester.com',
            'password' => Hash::make('password'),
            'role'     => 'member',
        ]);

        User::create([
            'name'     => 'Member2',
            'email'    => 'member2@tester.com',
            'password' => Hash::make('password'),
            'role'     => 'member',
        ]);
    }
}

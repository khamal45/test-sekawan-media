<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Approver 1',
            'email' => 'approver1@example.com',
            'password' => Hash::make('password'),
            'role' => 'approver',
        ]);
        User::create([
            'name' => 'Approver 2',
            'email' => 'approver2@example.com',
            'password' => Hash::make('password'),
            'role' => 'approver',
        ]);
    }
}

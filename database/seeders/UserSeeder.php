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
            'name' => 'Tambang 1',
            'email' => 'tambang1@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Tambang 2',
            'email' => 'tambang2@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'mahendra',
            'email' => 'approver1@example.com',
            'password' => Hash::make('password'),
            'role' => 'approver',
        ]);
        User::create([
            'name' => 'khamal',
            'email' => 'approver2@example.com',
            'password' => Hash::make('password'),
            'role' => 'approver',
        ]);
    }
}

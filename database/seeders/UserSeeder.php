<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin12345'),
            'role_id' => 1
        ]);

        User::create([
            'name' => 'guru',
            'email' => 'guru@gmail.com',
            'password' => Hash::make('guru12345'),
            'role_id' => 2
        ]);

        User::create([
            'name' => 'dafa',
            'email' => 'dafa@gmail.com',
            'password' => Hash::make('dafa12345'),
            'role_id' => 3
        ]);

        User::create([
            'name' => 'Rafli',
            'email' => 'rafli@gmail.com',
            'password' => Hash::make('rafli12345'),
            'role_id' => 3
        ]);
    }
}

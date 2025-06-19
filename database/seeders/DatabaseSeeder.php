<?php

namespace Database\Seeders;

use App\Models\Major;
use App\Models\Role;
use App\Models\Student;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Role::create([
            'name' => 'Admin',
        ]);
        Role::create([
            'name' => 'Guru',
        ]);
        Role::create([
            'name' => 'Ketua Kelas'
        ]);
        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin12345'),
            'role_id' => 1
        ]);
        User::create([
            'name' => 'guru',
            'email' => 'guru@gmail.com',
            'password' => bcrypt('guru12345'),
            'role_id' => 1
        ]);
        User::create([
            'name' => 'dafa',
            'email' => 'dafa@gmail.com',
            'password' => bcrypt('dafa12345'),
            'role_id' => 1
        ]);
        Major::create([
            'name' => 'Rekayasa Perangkat Lunak'
        ]);
    }
}

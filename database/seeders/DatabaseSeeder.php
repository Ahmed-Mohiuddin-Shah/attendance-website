<?php

namespace Database\Seeders;

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

        User::create([
            'fullname' => 'John Doe',
            'email' => 'johndoe@hey.com',
            'role' => 'student',
            'password' => bcrypt('password')
        ]);
        User::create([
            'fullname' => 'Jane Doe',
            'email' => 'janedoe@hey.com',
            'role' => 'teacher',
            'password' => bcrypt('password')
        ]);

        

    }
}

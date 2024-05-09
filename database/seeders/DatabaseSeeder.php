<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Attendance;
use App\Models\Attendancesheet;
use App\Models\Classroom;
use App\Models\Studclass;
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
            'fullname' => 'Jack Doe',
            'email' => 'jack@hey.com',
            'role' => 'student',
            'password' => bcrypt('password')
        ]);
        User::create([
            'fullname' => 'Jill Doe',
            'email' => 'jill@hey.com',
            'role' => 'student',
            'password' => bcrypt('password')
        ]);
        User::create([
            'fullname' => 'Jane Doe',
            'email' => 'janedoe@hey.com',
            'role' => 'teacher',
            'password' => bcrypt('password')
        ]);

        Classroom::create([
            'name' => 'Math 101',
            'teacher_id' => 2,
            'start_time' => '08',
            'end_time' => '09',
            'credit_hours' => 3
        ]);

        Attendance::create([
            'user_id' => 1,
            'class_id' => 1,
            'is_present' => true,
            'date' => '2021-09-01'
        ]);

        Studclass::create([
            'student_id' => 1,
            'class_id' => 1
        ]);

        Attendancesheet::create(
            [
                'student_id' => 1,
                'class_id' => 1,
                'date' => '2021-09-01',
                'status' => '1'
            ]
        );
    }
}

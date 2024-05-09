<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\User;
use App\Models\Studclass;
use App\Models\Attendancesheet;
use Illuminate\Support\Facades\Log;

class ClassController extends Controller
{
    public function create_class()
    {
        $classroom = new Classroom();
        $classroom->name = request('name');
        $classroom->start_time = request('start_date_time');
        $end_time = request('start_date_time');
        $end_time += 1;
        $classroom->end_time = $end_time;
        $classroom->credit_hours = request('credit_hours');
        $classroom->teacher_id = auth()->user()->id;
        $classroom->save();
        return redirect()->route('dashboard')->with('success', 'Class created!');
    }

    public function add_student()
    {
        $id = request('class_id');

        $request_array = request()->all();

        foreach ($request_array as $key => $value) {
            if (strpos($key, 'student') !== false) {
                // Log::info($value);
                $studclass = Studclass::create([
                    'student_id' => $value,
                    'class_id' => $id,
                ]);
                $studclass->save();
            }
            // Log::info($key);
        }

        return view('dashboard', [
            'classes' => Classroom::all(),
            'students' => User::all('id', 'fullname', 'role', 'email'),
        ])->with('success', 'Students added to class!');
    }

    function mark_attendance()
    {
        $class_id = request('class_id');
        $date = date('d-m-Y');

        $request_array = request()->all();

        foreach ($request_array as $key => $value) {
            if (strpos($key, 'student') !== false) {
                // Log::info($value);
                $attendance = Attendancesheet::create(
                    [
                        'student_id' => $value,
                        'class_id' => $class_id,
                        'date' => $date,
                        'status' => '1'
                    ]
                );
                $attendance->save();
            }
            // Log::info($key);
        }

        return redirect()->route('dashboard', [
            'classes' => Classroom::all(),
            'students' => User::all('id', 'fullname', 'role', 'email'),
        ])->with('success', 'Attendance marked!');
    }

    function viewattendance($class_id)
    {
        $students = Studclass::where('class_id', $class_id)->get('student_id');
        $attendance = Attendancesheet::where('class_id', $class_id)->get();

        

        return view('viewattendance', [
            'students' => $students,
            'attendance' => $attendance,
        ]);
    }
}

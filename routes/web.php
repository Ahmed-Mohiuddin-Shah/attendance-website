<?php

use App\Models\Attendancesheet;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClassController;
use App\Models\Attendance;
use App\Models\Classroom;
use App\Models\Studclass;
use App\Models\User;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login-page', function () {
    return view('login');
})->name('login-page');

Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::post('logout', function () {
    auth()->logout();
    return redirect()->route('login-page');
})->name('logout');

Route::get('/dashboard', function () {
    if (auth()->user()->role == 'student') {
        // Log::info(Studclass::where('student_id', auth()->user()->id)->get('class_id'));
        $studclass = Studclass::where('student_id', auth()->user()->id)->get('class_id');
        $classes = [];

        foreach ($studclass as $key => $class) {
            $classes[] = Classroom::find($class->class_id);
        }
        return view('dashboard', [
            'classes' => $classes,
        ]);
    }
    return view('dashboard', [
        'classes' => Classroom::all(),
        'students' => User::all('id', 'fullname', 'role', 'email'),
    ]);
})->name('dashboard');

Route::get('/register-page', function () {
    return view('register');
})->name('register-page');

Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::get('/profile', function () {
    return view('profile');
})->name('profile');

Route::post('create-class', [ClassController::class, 'create_class'])->name('create-class');

Route::get('class/{classroom}', function (Classroom $classroom) {
    return view('class', [
        'classroom' => $classroom
    ]);
})->name('class');

Route::post('class/{classroom}/add-student', function (Classroom $classroom) {
    $classroom->students()->attach(request('student_id'));
    return back()->with('success', 'Student added to class!');
})->name('add-student');

Route::post('class/{classroom}/remove-student', function (Classroom $classroom) {
    $classroom->students()->detach(request('student_id'));
    return back()->with('success', 'Student removed from class!');
})->name('remove-student');

Route::get("class/add-students-page/{id}", function ($id) {
    return view('addstudents', [
        'students' => User::all('id', 'fullname', 'role', 'email'),
        'students_in_class' => Studclass::where('class_id', $id)->get('student_id'),
        'classroom' => $id,
    ]);
})->name('add-students-page');

Route::post('class/add-students', [ClassController::class, 'add_student'])->name('add-students');

Route::get('class/mark-attendance-page/{id}', function ($id) {

    // Log::info(Attendancesheet::where('class_id', $id)->where('date', date('Y-m-d'))->exists());
    if (Attendancesheet::where('class_id', $id)->where('date', date('Y-m-d'))->exists()) {
        return redirect()->route('dashboard')->with('error', 'Attendance already marked for today!');
    }

    return view('markattendance', [
        'students' => User::find(Studclass::where('class_id', $id)->get('student_id')),
        'students_in_class' => Studclass::where('class_id', $id)->get('student_id'),
        'classroom' => Classroom::find($id),
    ]);
})->name('mark-attendance-page');

Route::post('class/mark-attendance', [ClassController::class, 'mark_attendance'])->name('mark-attendance');

Route::get('view-attendance-page/{id}', function ($id) {

        

    return view('viewattendance', [
        'classroom' => Classroom::find($id),
        'attendances' => Attendancesheet::where('class_id', $id)->get(),
    ]);
})->name('view-attendance-page');

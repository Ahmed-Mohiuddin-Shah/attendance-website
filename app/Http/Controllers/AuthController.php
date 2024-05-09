<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Models\User;

class AuthController extends Controller
{
    public function login()
    {
        request()->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = request()->only('email', 'password');
        if (auth()->attempt($credentials)) {
            Log::info('Login successful');
            return redirect()->route('dashboard')->with('success', 'Login successful!');
        }
        return redirect()->route('login-page')->with('error', 'Invalid credentials!');
    }
    public function register()
    {
        request()->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = new User();
        $user->fullname = request('name');
        $user->email = request('email');
        $user->password = bcrypt(request('password'));
        $user->role = request('role');
        $user->save();
        return redirect()->route('login-page')->with('success', 'User registered!');   
    }
}

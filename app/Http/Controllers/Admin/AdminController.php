<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Dashboard admin
    public function index()
    {
        return view('admin.dashboard');
    }

    // Form login admin
    public function showLoginForm()
    {
        return view('admin.login'); // Tạo view resources/views/admin/login.blade.php
    }


    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (auth()->guard('admin')->attempt($credentials)) {
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['email' => 'Email hoặc mật khẩu không đúng']);
    }

    // Logout admin
    public function logout()
    {
        auth()->guard('admin')->logout();
        return redirect()->route('admin.login.form');
    }
}

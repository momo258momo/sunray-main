<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * Hiển thị form đăng nhập
     */
    public function create()
    {
        return auth()->check()
            ? redirect()->route('home')
            : view('auth.login');
    }

    /**
     * Xử lý đăng nhập
     */
    public function store(Request $request)
    {
        // Validate dữ liệu đăng nhập
        $credentials = $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8|max:255',
        ]);

        // Thử đăng nhập
        if (auth()->attempt($credentials)) {

            // Chống session fixation
            $request->session()->regenerate();

            $fullName = str()->limit(auth()->user()->fullName, 25);

            return redirect()->route('home')
                ->with('success', "Welcome, $fullName");
        }

        // Sai tài khoản hoặc mật khẩu
        return back()
            ->withErrors([
                'email' => 'Email hoặc mật khẩu không đúng.',
            ])
            ->onlyInput('email');
    }
}

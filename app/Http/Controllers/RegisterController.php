<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    /**
     * Hiển thị form đăng ký
     */
    public function create()
    {
        return auth()->check()
            ? redirect()->route('home')
            : view('auth.register');
    }

    /**
     * Xử lý đăng ký
     */
    public function store(Request $request)
    {
        // Validate dữ liệu đăng ký
        $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name'  => 'required|string|max:50',
            'email'      => 'required|string|email|max:255|unique:users,email',
            'password'   => [
                'required',
                'confirmed',
                Password::min(8)   // tối thiểu 8 ký tự
                    ->letters()    // có chữ
                    ->numbers(),   // có số
            ],
        ]);

        // Tạo user mới
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'password'   => bcrypt($request->password),
        ]);

        // Tự động đăng nhập sau khi đăng ký
        auth()->login($user);
        $request->session()->regenerate();

        $fullName = str()->limit($user->fullName, 25);

        return redirect()->route('home')
            ->with('success', "Welcome, $fullName");
    }
}

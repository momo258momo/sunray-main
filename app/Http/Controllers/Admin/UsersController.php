<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * Danh sách người dùng
     */
    public function index()
    {
        $users = User::all();
        return view('admin.user.users', compact('users'));
    }

    /**
     * Form tạo người dùng
     */
    public function create()
    {
        return view('admin.user.create_user');
    }

    /**
     * Lưu người dùng mới
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'first_name' => [
                    'required',
                    'string',
                    'max:255',
                    'regex:/^[\pL\s]+$/u',
                ],
                'last_name' => [
                    'required',
                    'string',
                    'max:255',
                    'regex:/^[\pL\s]+$/u',
                ],
                'email' => 'required|email:rfc,dns|max:255|unique:users,email',
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'confirmed',
                    'regex:/[A-Z]/',
                    'regex:/[a-z]/',
                    'regex:/[0-9]/',
                ],
            ],
            [
                'first_name.regex' => 'Tên chỉ được chứa chữ cái',
                'last_name.regex' => 'Họ chỉ được chứa chữ cái',
                'password.regex' => 'Mật khẩu phải có chữ hoa, chữ thường và số',
            ]
        );

        User::create([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => strtolower($request->email),
            'password'   => Hash::make($request->password),
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Người dùng đã được tạo thành công.');
    }

    /**
     * Form chỉnh sửa người dùng
     */
    public function edit(User $user)
    {
        return view('admin.user.edit_user', compact('user'));
    }

    /**
     * Cập nhật người dùng
     */
    public function update(Request $request, User $user)
    {
        $request->validate(
            [
                'first_name' => [
                    'required',
                    'string',
                    'max:255',
                    'regex:/^[\pL\s]+$/u',
                ],
                'last_name' => [
                    'required',
                    'string',
                    'max:255',
                    'regex:/^[\pL\s]+$/u',
                ],
                'email' => 'required|email:rfc,dns|max:255|unique:users,email,' . $user->id,
            ],
            [
                'first_name.regex' => 'Tên chỉ được chứa chữ cái',
                'last_name.regex' => 'Họ chỉ được chứa chữ cái',
            ]
        );

        $user->update([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => strtolower($request->email),
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Người dùng đã được cập nhật.');
    }

    /**
     * Xóa người dùng
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Người dùng đã được xóa.');
    }
}

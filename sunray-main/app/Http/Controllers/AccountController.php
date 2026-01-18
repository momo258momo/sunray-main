<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class AccountController extends Controller
{
    /**
     * Hiển thị thông tin tài khoản và số đơn hàng.
     */
    public function show(Request $request)
    {
        // Kiểm tra user đã đăng nhập
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login.create')->with('error', 'Bạn cần đăng nhập để xem tài khoản.');
        }

        // Đếm số đơn hàng của user
        $orders_count = Order::where('user_id', $user->id)->count();

        return view('account.show', compact('user', 'orders_count'));
    }
}

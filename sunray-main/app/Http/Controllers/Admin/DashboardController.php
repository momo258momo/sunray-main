<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Hiển thị dashboard admin
     */
    public function index()
    {
        $today = Carbon::today();
        
        // SỬ DỤNG CÁC HẰNG SỐ CHUỖI ĐƯỢC ĐỊNH NGHĨA TRONG MODEL ORDER
        $deliveredStatus = Order::DELIVERED;
        $pendingStatus = Order::PENDING;

        // 1. Dữ liệu Đơn hàng Mới nhất (5 đơn)
        $latestOrders = Order::orderBy('created_at', 'desc')->take(5)->get();

        // 2. Dữ liệu Biểu đồ Doanh thu 7 ngày
        $dates = collect();
        $revenues = collect();
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $total = Order::whereDate('created_at', $date)
                          ->where('status', $deliveredStatus) // Chỉ tính đơn hàng đã giao
                          ->sum('total');

            $dates->push($date->format('d/m'));
            $revenues->push($total);
        }

        return view('admin.dashboard', [
            // ===================================
            // THỐNG KÊ CHUNG 
            // ===================================
            'totalUsers' => User::count(),
            'totalProducts' => Product::count(),
            'totalOrders' => Order::count(),

            // ===================================
            // THỐNG KÊ HÔM NAY 
            // ===================================
            'ordersToday' => Order::whereDate('created_at', $today)->count(),
            'revenueToday' => Order::whereDate('created_at', $today)
                ->where('status', $deliveredStatus)
                ->sum('total'),
            'pendingOrders' 	=> Order::where('status', $pendingStatus)->count(),
            
            // ===================================
            // DỮ LIỆU BỔ SUNG CHO ĐỒ THỊ/BẢNG 
            // ===================================
            'latestOrders' => $latestOrders,
            'chartLabels' => $dates->toJson(),
            'chartData' => $revenues->toJson(),
        ]);
    }

    /**
     * Form login admin
     */
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    /**
     * Xử lý login admin
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' 	=> ['required', 'email'],
            'password' => ['required'],
        ]);

        // Bạn cần chắc chắn rằng guard 'admin' đã được cấu hình đúng.
        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'email' => 'Email hoặc mật khẩu không đúng.',
        ]);
    }

    /**
     * Logout admin
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login.form');
    }
}
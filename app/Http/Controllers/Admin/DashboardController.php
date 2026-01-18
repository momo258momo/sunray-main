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
    public function index()
    {
        // hôm nay theo timezone app
        $today = Carbon::now()->startOfDay();

        // constant trong model Order
        $deliveredStatus = Order::DELIVERED;   // 'delivered'
        $pendingStatus   = Order::PENDING;     // 'pending'

        /**
         * 1. 5 đơn hàng mới nhất
         * preload user + chỉ lấy first_name,last_name
         */
        $latestOrders = Order::with([
            'user' => function ($q) {
                $q->select('id', 'first_name', 'last_name');
            }
        ])
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get();

        /**
         * 2. Doanh thu 7 ngày gần nhất
         * hiển thị theo đúng thứ tự
         * dữ liệu khớp ngày trên trục X
         */
        $chartLabels = [];
        $chartData   = [];

        for ($i = 6; $i >= 0; $i--) {

            $date = Carbon::now()->subDays($i)->startOfDay();

            $chartLabels[] = $date->format('d/m');

            $chartData[] = Order::whereDate('created_at', $date)
                ->where('status', $deliveredStatus)
                ->sum('total');
        }

        return view('admin.dashboard', [
            // thống kê chung
            'totalUsers'    => User::count(),
            'totalProducts' => Product::count(),
            'totalOrders'   => Order::count(),

            // thống kê hôm nay
            'ordersToday' => Order::whereDate('created_at', $today)->count(),

            'revenueToday' => Order::whereDate('created_at', $today)
                ->where('status', $deliveredStatus)
                ->sum('total'),

            'pendingOrders' => Order::where('status', $pendingStatus)->count(),

            // dữ liệu bổ sung
            'latestOrders' => $latestOrders,
            'chartLabels'  => $chartLabels,
            'chartData'    => $chartData,
        ]);
    }

    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'email' => 'Email hoặc mật khẩu không đúng.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login.form');
    }
}

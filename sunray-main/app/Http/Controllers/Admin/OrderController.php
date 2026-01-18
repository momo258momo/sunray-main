<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')
            ->latest()
            ->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('orderItems.product', 'user');

        // Chỉ gửi các trạng thái hợp lệ cho view
        $statuses = collect(Order::getStatusLabels())
            ->only($order->nextAllowedStatuses())
            ->toArray();

        return view('admin.orders.show', compact('order', 'statuses'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        // ❌ Đơn kết thúc rồi thì cấm sửa
        if ($order->isFinal()) {
            return back()->with('error', 'Đơn hàng đã kết thúc, không thể cập nhật');
        }

        $allowedStatuses = $order->nextAllowedStatuses();

        $request->validate([
            'status' => ['required', Rule::in($allowedStatuses)],
        ]);

        $newStatus = $request->status;

        // Hoàn kho nếu HỦY hoặc TRẢ
        if (in_array($newStatus, [Order::CANCELLED, Order::RETURNED])) {
            foreach ($order->orderItems as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->increment('stock_quantity', $item->quantity);
                }
            }
        }

        $order->update(['status' => $newStatus]);

        return back()->with('success', 'Cập nhật trạng thái thành công');
    }
}

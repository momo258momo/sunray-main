<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Hiển thị danh sách đơn hàng của người dùng
     */
    public function index(Request $request): View
    {
        $orders = Order::with(['orderItems.product', 'user'])
            ->where('user_id', auth()->id())
            ->latest()
            ->simplePaginate(10);

        return view('orders.index', compact('orders'));
    }

    /**
     * Hiển thị chi tiết đơn hàng
     */
    public function show($id): View
    {
        $order = Order::with([
            'orderItems.product',
            'orderItems.review.user', // 🔥 QUAN TRỌNG
        ])->findOrFail($id);

        return view('orders.show', compact('order'));
    }

    /**
     * Hủy đơn hàng (chỉ khi PENDING)
     */
    public function cancel(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Bạn không có quyền thao tác trên đơn hàng này.');
        }

        if ($order->status !== Order::PENDING) {
            return redirect()->back()->with(
                'error',
                'Không thể hủy đơn hàng ở trạng thái hiện tại.'
            );
        }

        try {
            DB::beginTransaction();

            $order->update(['status' => Order::CANCELLED]);

            foreach ($order->orderItems as $item) {
                if ($product = Product::find($item->product_id)) {
                    $product->increment('stock_quantity', $item->quantity);
                }
            }

            DB::commit();

            return redirect()->back()->with(
                'success',
                'Đơn hàng #' . $order->order_number . ' đã được hủy thành công.'
            );
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with(
                'error',
                'Đã xảy ra lỗi hệ thống, vui lòng thử lại.'
            );
        }
    }

    /**
     * Xác nhận đã nhận hàng
     */
    public function markReceived(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            return redirect()->route('orders.index')
                ->with('error', 'Bạn không có quyền thao tác.');
        }

        if ($order->status !== Order::SHIPPING) {
            return redirect()->back()
                ->with('error', 'Đơn hàng này không thể xác nhận.');
        }

        $order->update([
            'status' => Order::DELIVERED
        ]);

        return redirect()
            ->route('orders.show', $order->id)
            ->with('show_review_form', true)
            ->with('success', 'Bạn đã xác nhận nhận hàng. Vui lòng đánh giá sản phẩm!');
    }

    /**
     * Trả hàng
     */
    public function returnOrder(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            return redirect()->route('orders.index')
                ->with('error', 'Bạn không có quyền thao tác.');
        }

        $order->update([
            'status' => Order::RETURNED
        ]);

        return redirect()->back()->with(
            'success',
            'Đơn hàng #' . $order->order_number . ' đã được đánh dấu là đã trả.'
        );
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Order;
use App\Models\Product; // Cần dùng Model Product để hoàn trả tồn kho
use Illuminate\Support\Facades\DB; // ✅ Dùng DB cho Transaction

class OrderController extends Controller
{
    /**
     * Hiển thị danh sách đơn hàng của người dùng đang đăng nhập
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
    public function show(Order $order): View
    {
        // Kiểm tra quyền sở hữu
        if ($order->user_id !== auth()->id()) {
            return redirect()->route('orders.index')->with('error', 'Bạn không có quyền xem đơn hàng này.');
        }

        return view('orders.show', compact('order'));
    }

    /**
     * Cho phép người dùng hủy đơn hàng (chỉ khi ở trạng thái PENDING)
     */
    public function cancel(Order $order): \Illuminate\Http\RedirectResponse
    {
        // 1. Kiểm tra quyền sở hữu
        if ($order->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Bạn không có quyền thao tác trên đơn hàng này.');
        }

        // 2. Kiểm tra trạng thái
        if ($order->status !== Order::PENDING) {
            return redirect()->back()->with('error', 'Không thể hủy đơn hàng ở trạng thái hiện tại (Chỉ có thể hủy khi đang "Chờ xác nhận").');
        }

        // 3. Thực hiện hủy và hoàn trả tồn kho trong Transaction
        try {
            DB::beginTransaction(); // Bắt đầu Transaction

            // Cập nhật trạng thái đơn hàng
            $order->update(['status' => Order::CANCELLED]);

            // Hoàn trả tồn kho cho các sản phẩm trong đơn hàng
            foreach ($order->orderItems as $item) {
                $product = Product::find($item->product_id); 
                
                if ($product) {
                    $product->stock_quantity += $item->quantity;
                    $product->save();
                }
            }
            
            DB::commit(); // Hoàn tất Transaction

            return redirect()->back()->with('success', 'Đơn hàng #' . $order->order_number . ' đã được hủy thành công và tồn kho đã được hoàn lại.');

        } catch (\Exception $e) {
            DB::rollBack(); // Rollback nếu có lỗi xảy ra
            return redirect()->back()->with('error', 'Đã xảy ra lỗi hệ thống trong quá trình hủy đơn hàng. Vui lòng thử lại sau.');
        }
    }

    /**
     * Đánh dấu đơn hàng là đã nhận được
     */
    public function markReceived(Order $order): \Illuminate\Http\RedirectResponse
{
    // Kiểm tra quyền sở hữu
    if ($order->user_id !== auth()->id()) {
        return redirect()->route('orders.index')
            ->with('error', 'Bạn không có quyền thao tác trên đơn hàng này.');
    }

    // Chỉ cho phép xác nhận khi đang giao hàng
    if ($order->status !== Order::SHIPPING) {
        return redirect()->back()
            ->with('error', 'Đơn hàng này không thể xác nhận đã nhận.');
    }

    // Cập nhật trạng thái
    $order->update([
        'status' => Order::DELIVERED
    ]);

    // 🔥 QUAN TRỌNG: bật form đánh giá
    return redirect()
        ->route('orders.show', $order->id)
        ->with('show_review_form', true)
        ->with('success', 'Bạn đã xác nhận nhận hàng. Vui lòng đánh giá sản phẩm!');
}


    /**
     * Xử lý trả hàng cho đơn hàng
     */
    public function returnOrder(Order $order): \Illuminate\Http\RedirectResponse
    {
        // Kiểm tra quyền sở hữu
        if ($order->user_id !== auth()->id()) {
            return redirect()->route('orders.index')->with('error', 'Bạn không có quyền thao tác trên đơn hàng này.');
        }

        // Cập nhật trạng thái đơn hàng
        $order->update(['status' => Order::RETURNED]); // Cập nhật trạng thái thành "Đã trả hàng"

        // Có thể thêm logic để xử lý việc hoàn trả hàng trong kho nếu cần thiết

        return redirect()->back()->with('success', 'Đơn hàng #' . $order->order_number . ' đã được đánh dấu là đã trả.');
    }
}
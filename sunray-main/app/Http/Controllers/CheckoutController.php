<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use App\Services\CartService;

class CheckoutController extends Controller
{
    private CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * Hiển thị trang checkout
     */
    public function create()
    {
        $subTotal = $this->cartService->getCartSubTotal();

        return view('checkout.create', compact('subTotal'));
    }

    /**
     * Lưu đơn hàng (COD)
     */
    public function store(Request $request)
    {
        // Validate dữ liệu nhập từ form
        $request->validate([
            'phone_number' => 'required|string|digits:10',
            'address'      => 'required|string|max:150',
            'order_notes'  => 'nullable|string|max:150',
        ]);

        DB::transaction(function () use ($request) {

            // Lấy giỏ hàng (mảng)
            $cartItems = $this->cartService->getCartItems();
            $subTotal  = $this->cartService->getCartSubTotal();
            $shippingFee = 20000;
            $total = $subTotal + $shippingFee;

            // Sinh order_number liên tục (INT)
            $lastOrder = Order::orderByDesc('order_number')->first();
            $orderNumber = $lastOrder ? $lastOrder->order_number + 1 : 10001;

            // Chuẩn bị dữ liệu order
            $orderData = [
                'order_number' => $orderNumber,
                'user_id'      => auth()->id(),
                'phone_number' => $request->phone_number,
                'address'      => $request->address,
                'order_notes'  => $request->order_notes,
                'subtotal'     => $subTotal,
                'shipping_fee' => $shippingFee,
                'total'        => $total,
                'status'       => Order::PENDING,
            ];

            // Tạo order
            $order = Order::createOrder($orderData);

            // Lưu order items (không lưu total)
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $item['product_id'], // đúng key trong mảng
                    'quantity'   => $item['quantity'],
                    'price'      => $item['price'],
                ]);
            }

            // Lưu order_number vào session để hiển thị trang xác nhận
            session()->put('order_number', $order->order_number);
        });

        return redirect()->route('confirmation');
    }
}

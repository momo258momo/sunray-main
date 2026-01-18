<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Product;
use App\Services\CartService;

class CartController extends Controller
{

    private CartService $cartService;


    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
        
    }

    /**
     * Display a listing of the resource.
     */
    public function index() 
    {
        // Lấy danh sách sản phẩm và tổng tiền trong giỏ hàng
        $cartItems = $this->cartService->getCartItems();
        $subTotal = $this->cartService->getCartSubTotal();
        
        return view('cart.index', compact('cartItems', 'subTotal'));
    }

    /**
     * Store a newly created resource in storage.
     * Xử lý thêm sản phẩm vào giỏ hàng (Cộng dồn số lượng và kiểm tra tồn kho)
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_slug' => 'required|exists:products,slug',
            'quantity' => 'nullable|numeric|min:1', 
        ]);

        $quantity = $request->quantity ?? 1;
        $product = Product::where('slug', $request->product_slug)->FirstOrFail();

        try {
            $this->cartService->addCartItem($product, $quantity);
            return redirect()->back()->with('success', 'Giỏ hàng đã được cập nhật thành công.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

    }

    /**
     * Update the specified resource in storage.
     * Dùng để xóa 1 item (tương đương DELETE)
     */
    public function update(Request $request, int $product_id)
{
    $request->validate([
        'quantity' => 'required|integer',
    ]);

    try {
        $this->cartService->updateCartItemQuantity(
            $product_id,
            $request->quantity
        );

        return redirect()
            ->route('cart.index')
            ->with('success', 'Cập nhật giỏ hàng thành công');
    } catch (\Exception $e) {
        return redirect()
            ->route('cart.index')
            ->with('error', $e->getMessage());
    }
}


    /**
     * Xử lý xóa toàn bộ giỏ hàng (Route mới: DELETE cart)
     */
    public function destroyAll()
    {
        $this->cartService->emptyCart();

        return redirect()->route('cart.index')->with('success', 'Đã xóa toàn bộ giỏ hàng.');
    }

    // Các phương thức create, show, edit không cần thiết cho giỏ hàng đã được bỏ.
}
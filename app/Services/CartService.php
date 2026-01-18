<?php

namespace App\Services;

use App\Models\Product; // Quan trọng: Đảm bảo Product model được sử dụng

class CartService {


    public function getCartItems() : ?array
{
    $cartItems = session('cart_items') ?? [];

    foreach ($cartItems as $key => $item) {
        if (!isset($item['stock_quantity'])) {
            $product = Product::find($item['product_id']);
            if ($product) {
                $cartItems[$key]['stock_quantity'] = $product->stock_quantity;
            }
        }
    }

    session()->put('cart_items', $cartItems);

    return $cartItems;
}



    public function emptyCart() : void {

        session()->forget('cart_items');

    }

    public function addCartItem($product, $quantity) : void {

        $quantity = (int) $quantity;
        $productFound = false;
        $cartItems = session('cart_items') ?? [];


        // BƯỚC 1: TÌM VÀ CỘNG DỒN SỐ LƯỢNG (KÈM KIỂM TRA TỒN KHO)
        if (!empty($cartItems)) {
            
            // Dùng & để thay đổi giá trị trực tiếp trong session array
            foreach ($cartItems as $key => &$cartItem) {

                if (isset($cartItem['product_id']) && $cartItem['product_id'] == $product->id) {

                    $currentQuantityInCart = $cartItem['quantity'];
                    $totalQuantity = $currentQuantityInCart + $quantity;

                    // KIỂM TRA TỒN KHO (Nếu vượt quá)
                    if ($totalQuantity > $product->stock_quantity) {
                        $availableStock = $product->stock_quantity - $currentQuantityInCart;
                        // Ném exception để Controller bắt và hiển thị thông báo
                        throw new \Exception("Chỉ có thể thêm tối đa $availableStock sản phẩm này vào giỏ hàng (Tồn kho: {$product->stock_quantity}).");
                    }

                    // Nếu đủ tồn kho, tiến hành cộng dồn
                    $cartItem['quantity'] = $totalQuantity;
                    $productFound = true;
                    
                    // Cập nhật session sau khi chỉnh sửa
                    session()->put('cart_items', $cartItems);
                    
                    return; // Hoàn tất xử lý
                }
            }
        }

        // BƯỚC 2: THÊM MỚI SẢN PHẨM (Nếu chưa có trong giỏ)
        if(!$productFound) {
            
            // KIỂM TRA TỒN KHO CHO LẦN THÊM ĐẦU TIÊN
            if ($quantity > $product->stock_quantity) {
                throw new \Exception("Số lượng yêu cầu ({$quantity}) vượt quá số lượng tồn kho ({$product->stock_quantity}).");
            }
            
            $item = [
                'product_id' => $product->id,
                'quantity' => $quantity,
                'name' => $product->name, 
                'price' => $product->price, 
                'image_url' => $product->image_url,
                'stock_quantity' => $product->stock_quantity,
            ];

            // product not found in the cart, so add it
            session()->push('cart_items', $item);
        }
    }


    public function removeCartItem(int $id) : void {

        $cartItems = session('cart_items');

        foreach ($cartItems as $key => $cartItem) {

            if (isset($cartItem['product_id']) && $cartItem['product_id'] == $id) {
                
                // remove the item from the cart
                session()->forget("cart_items.$key");
                    
            }
        }

    }


    public function getCartSubTotal() : float {

        $subTotal = 0;

        $cartItems = session('cart_items');

        if(session()->has('cart_items')){

            foreach ($cartItems as $key => $cartItem) {

                // Đã sửa: Truy cập thuộc tính $cartItem['price'] thay vì $cartItem->price
                $subTotal += $cartItem['price'] * $cartItem['quantity']; 
                
            }
        }

        return $subTotal;

    }

    public function getCartItemsCount() : int
    {
        
        $totalQuantity = 0;

        if(session()->has('cart_items')){

            foreach (session('cart_items') as $key => $cartItem) {

                $totalQuantity += $cartItem['quantity']; 
                
            }

        }

        return $totalQuantity;

    }
    public function updateCartItemQuantity(int $productId, int $quantity) : void
{
    $cartItems = session('cart_items') ?? [];

    foreach ($cartItems as $key => $cartItem) {

        if ($cartItem['product_id'] == $productId) {

            // quantity <= 0 → xóa
            if ($quantity <= 0) {
                session()->forget("cart_items.$key");
                return;
            }

            $product = Product::findOrFail($productId);

            // vượt tồn kho
            if ($quantity > $product->stock_quantity) {
                throw new \Exception('Số lượng vượt quá tồn kho');
            }

            // cập nhật
            $cartItems[$key]['quantity'] = $quantity;
            session()->put('cart_items', $cartItems);
            return;
        }
    }

    throw new \Exception('Sản phẩm không tồn tại trong giỏ hàng');
}


}
<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    /**
     * Đánh giá 1 sản phẩm (giữ lại – không đụng)
     */
    public function store(Request $request)
    {
        $request->validate([
            'order_item_id' => 'required|exists:order_items,id',
            'product_id'    => 'required|exists:products,id',
            'rating'        => 'required|integer|min:1|max:5',
            'comment'       => 'nullable|string|max:1000',
        ]);

        $exists = Review::where('order_item_id', $request->order_item_id)
            ->where('user_id', Auth::id())
            ->exists();

        if ($exists) {
            return back()->with('error', 'Bạn đã đánh giá sản phẩm này rồi.');
        }

        Review::create([
            'user_id'       => Auth::id(),
            'product_id'    => $request->product_id,
            'order_item_id' => $request->order_item_id,
            'rating'        => $request->rating,
            'comment'       => $request->comment,
        ]);

        return back()->with('success', 'Cảm ơn bạn đã đánh giá sản phẩm!');
    }

    /**
     * 🔥 Đánh giá NHIỀU sản phẩm – 1 form – 1 nút gửi
     */
    public function storeMultiple(Request $request)
    {
        $request->validate([
            'items'                 => 'required|array',
            'items.*.order_item_id' => 'required|exists:order_items,id',
            'items.*.product_id'    => 'required|exists:products,id',
            'items.*.rating'        => 'required|integer|min:1|max:5',
            'items.*.comment'       => 'nullable|string|max:1000',
        ]);

        DB::beginTransaction();

        try {
            foreach ($request->items as $item) {

                // ❌ Nếu đã đánh giá rồi thì bỏ qua
                $exists = Review::where('order_item_id', $item['order_item_id'])
                    ->where('user_id', Auth::id())
                    ->exists();

                if ($exists) {
                    continue;
                }

                Review::create([
                    'user_id'       => Auth::id(),
                    'product_id'    => $item['product_id'],
                    'order_item_id' => $item['order_item_id'],
                    'rating'        => $item['rating'],
                    'comment'       => $item['comment'] ?? null,
                ]);
            }

            DB::commit();

            return back()->with('success', 'Đánh giá sản phẩm thành công!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra khi gửi đánh giá.');
        }
    }
}

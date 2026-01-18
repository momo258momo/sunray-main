<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ReturnRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReturnController extends Controller
{
    public function create(Order $order)
    {
        abort_if($order->status !== Order::DELIVERED, 403);

        return view('returns.create', compact('order'));
    }

    public function store(Request $request, Order $order)
    {
        abort_if($order->status !== Order::DELIVERED, 403);

        $request->validate([
            'selected_items' => 'required|array|min:1',
        ], [
            'selected_items.required' => 'Vui lòng chọn ít nhất 1 sản phẩm để trả',
        ]);

        DB::transaction(function () use ($request, $order) {

            foreach ($request->selected_items as $itemId) {

                $data = $request->items[$itemId] ?? null;
                if (!$data || empty($data['reason_code'])) {
                    continue;
                }

                $path = null;
                if (isset($data['image'])) {
                    $path = $data['image']->store('returns', 'public');
                }

                ReturnRequest::create([
                    'order_id'       => $order->id,
                    'order_item_id'  => $itemId,
                    'reason'         => $data['reason_code']
                        . ($data['reason_detail'] ? ' - ' . $data['reason_detail'] : ''),
                    'image'          => $path,
                    'status'         => ReturnRequest::PENDING,
                ]);
            }

            // cập nhật trạng thái đơn
            $order->update([
                'status' => Order::RETURN_PENDING
            ]);
        });

        return redirect()
            ->route('orders.show', $order)
            ->with('success', 'Đã gửi yêu cầu trả hàng, vui lòng chờ duyệt');
    }
}

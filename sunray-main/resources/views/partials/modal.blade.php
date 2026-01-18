<div class="modal fade"
     id="order-{{ $order->id }}"
     data-bs-backdrop="static"
     data-bs-keyboard="false"
     tabindex="-1"
     aria-hidden="true">

    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- HEADER -->
            <div class="modal-header">
                <h4 class="modal-title fs-6">
                    Đơn hàng số: {{ $order->order_number }}
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
            </div>

            <!-- BODY -->
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="small">
                            <tr>
                                <th></th>
                                <th>Sản phẩm</th>
                                <th class="text-center">Số lượng</th>
                                <th class="text-end">Đơn giá</th>
                                <th class="text-end">Thành tiền</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($order->orderItems as $orderItem)
                            <tr>
                                <td style="width: 7rem;">
                                    <img src="{{ asset('storage/' . $orderItem->product->image_url) }}"
                                         alt="{{ $orderItem->product->name }}"
                                         class="rounded w-100"
                                         style="min-width: 5rem;">
                                </td>

                                <td>
                                    <a href="{{ url('products/' . $orderItem->product->slug) }}"
                                       target="_blank"
                                       class="text-body">
                                        {{ $orderItem->product->name }}
                                    </a>
                                </td>

                                <td class="text-center">{{ $orderItem->quantity }}</td>

                                <!-- VNĐ -->
                                <td class="text-end">
                                    {{ number_format($orderItem->price, 0, ',', '.') }} VNĐ
                                </td>

                                <td class="text-end">
                                    {{ number_format($orderItem->price * $orderItem->quantity, 0, ',', '.') }} VNĐ
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                        <!-- FOOTER -->
                        <tfoot class="fw-bold">
                            <tr>
                                <td colspan="3"></td>
                                <td>Tạm tính</td>
                                <td class="text-end">
                                    {{ number_format($order->subtotal, 0, ',', '.') }} VNĐ
                                </td>
                            </tr>

                            <tr>
                                <td colspan="3"></td>
                                <td>Phí ship</td>
                                <td class="text-end">
                                    {{ number_format($order->shipping_fee, 0, ',', '.') }} VNĐ
                                </td>
                            </tr>

                            <tr class="text-danger">
                                <td colspan="3"></td>
                                <td>Tổng cộng</td>
                                <td class="text-end">
                                    {{ number_format($order->total, 0, ',', '.') }} VNĐ
                                </td>
                            </tr>
                        </tfoot>

                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

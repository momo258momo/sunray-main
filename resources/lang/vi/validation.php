<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines (FULL cho TMĐT)
    |--------------------------------------------------------------------------
    */

    'accepted' => 'Trường :attribute phải được chấp nhận.',
    'accepted_if' => 'Trường :attribute phải được chấp nhận khi :other là :value.',
    'active_url' => 'Trường :attribute không phải là URL hợp lệ.',
    'after' => 'Trường :attribute phải là ngày sau :date.',
    'after_or_equal' => 'Trường :attribute phải là ngày sau hoặc bằng :date.',
    'alpha' => 'Trường :attribute chỉ được chứa chữ cái.',
    'alpha_dash' => 'Trường :attribute chỉ được chứa chữ cái, số, dấu gạch ngang và gạch dưới.',
    'alpha_num' => 'Trường :attribute chỉ được chứa chữ cái và số.',
    'array' => 'Trường :attribute phải là mảng.',
    'before' => 'Trường :attribute phải là ngày trước :date.',
    'before_or_equal' => 'Trường :attribute phải là ngày trước hoặc bằng :date.',
    'boolean' => 'Trường :attribute phải là true hoặc false.',

    'between' => [
        'numeric' => 'Trường :attribute phải nằm trong khoảng :min đến :max.',
        'file' => 'Trường :attribute phải có dung lượng từ :min đến :max KB.',
        'string' => 'Trường :attribute phải có độ dài từ :min đến :max ký tự.',
        'array' => 'Trường :attribute phải có từ :min đến :max phần tử.',
    ],

    'confirmed' => 'Xác nhận :attribute không khớp.',
    'current_password' => 'Mật khẩu hiện tại không đúng.',
    'date' => 'Trường :attribute không phải là ngày hợp lệ.',
    'date_equals' => 'Trường :attribute phải là ngày bằng với :date.',
    'date_format' => 'Trường :attribute không đúng định dạng :format.',

    // Checkout
    'digits' => 'Trường :attribute phải có đúng :digits chữ số.',
    'digits_between' => 'Trường :attribute phải có từ :min đến :max chữ số.',

    'email' => 'Trường :attribute phải là địa chỉ email hợp lệ.',
    'ends_with' => 'Trường :attribute phải kết thúc bằng một trong các giá trị: :values.',
    'exists' => 'Giá trị đã chọn cho :attribute không tồn tại.',
    'file' => 'Trường :attribute phải là tệp tin.',
    'filled' => 'Trường :attribute không được để trống.',

    'gt' => [
        'numeric' => 'Trường :attribute phải lớn hơn :value.',
    ],
    'gte' => [
        'numeric' => 'Trường :attribute phải lớn hơn hoặc bằng :value.',
    ],

    // Upload ảnh
    'image' => 'Trường :attribute phải là hình ảnh.',
    'in' => 'Giá trị đã chọn cho :attribute không hợp lệ.',
    'integer' => 'Trường :attribute phải là số nguyên.',
    'ip' => 'Trường :attribute phải là địa chỉ IP hợp lệ.',
    'json' => 'Trường :attribute phải là chuỗi JSON hợp lệ.',

    // Giá – số lượng
    'max' => [
        'numeric' => 'Trường :attribute không được lớn hơn :max.',
        'file' => 'Trường :attribute không được lớn hơn :max KB.',
        'string' => 'Trường :attribute không được dài hơn :max ký tự.',
        'array' => 'Trường :attribute không được có nhiều hơn :max phần tử.',
    ],
    'min' => [
        'numeric' => 'Trường :attribute phải lớn hơn hoặc bằng :min.',
        'file' => 'Trường :attribute phải có dung lượng ít nhất :min KB.',
        'string' => 'Trường :attribute phải có ít nhất :min ký tự.',
        'array' => 'Trường :attribute phải có ít nhất :min phần tử.',
    ],

    'mimes' => 'Trường :attribute phải có định dạng: :values.',
    'mimetypes' => 'Trường :attribute phải có định dạng: :values.',
    'multiple_of' => 'Trường :attribute phải là bội số của :value.',

    'not_in' => 'Giá trị đã chọn cho :attribute không hợp lệ.',
    'not_regex' => 'Định dạng của :attribute không hợp lệ.',
    'numeric' => 'Trường :attribute phải là số.',

    'present' => 'Trường :attribute phải tồn tại.',
    'prohibited' => 'Trường :attribute không được phép.',
    'regex' => 'Định dạng của :attribute không hợp lệ.',
    'required' => 'Trường :attribute không được để trống.',
    'required_if' => 'Trường :attribute là bắt buộc.',
    'required_unless' => 'Trường :attribute là bắt buộc.',
    'required_with' => 'Trường :attribute là bắt buộc.',
    'required_without' => 'Trường :attribute là bắt buộc.',
    'same' => 'Trường :attribute và :other phải giống nhau.',

    'size' => [
        'numeric' => 'Trường :attribute phải bằng :size.',
        'file' => 'Trường :attribute phải có dung lượng :size KB.',
        'string' => 'Trường :attribute phải có độ dài :size ký tự.',
        'array' => 'Trường :attribute phải chứa :size phần tử.',
    ],

    'string' => 'Trường :attribute phải là chuỗi.',
    'timezone' => 'Trường :attribute phải là múi giờ hợp lệ.',
    'unique' => 'Trường :attribute đã tồn tại.',
    'url' => 'Trường :attribute phải là URL hợp lệ.',

    /*
    |--------------------------------------------------------------------------
    | Password Rules
    |--------------------------------------------------------------------------
    */
    'password' => [
        'min' => 'Mật khẩu phải có ít nhất :min ký tự.',
        'letters' => 'Mật khẩu phải chứa ít nhất một chữ cái.',
        'numbers' => 'Mật khẩu phải chứa ít nhất một chữ số.',
        'symbols' => 'Mật khẩu phải chứa ít nhất một ký tự đặc biệt.',
        'mixed' => 'Mật khẩu phải chứa chữ hoa và chữ thường.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Attributes (Tên field tiếng Việt – CỰC QUAN TRỌNG)
    |--------------------------------------------------------------------------
    */
    'attributes' => [

        // Auth
        'first_name' => 'tên',
        'last_name' => 'họ',
        'email' => 'email',
        'password' => 'mật khẩu',
        'password_confirmation' => 'xác nhận mật khẩu',

        // Checkout
        'receiver_name' => 'tên người nhận',
        'phone' => 'số điện thoại',
        'phone_number' => 'số điện thoại',
        'address' => 'địa chỉ giao hàng',
        'order_notes' => 'ghi chú đơn hàng',

        // Product (ĐỒ ÁN)
        'name' => 'tên sản phẩm',
        'short_description' => 'mô tả ngắn',
        'long_description' => 'mô tả chi tiết',

        'category' => 'danh mục',
        'shape' => 'dáng kính',
        'material' => 'chất liệu',
        'color' => 'màu sắc',

        'price' => 'giá bán',
        'stock_quantity' => 'số lượng tồn kho',
        'status' => 'trạng thái sản phẩm',

        'image' => 'ảnh đại diện',
        'images' => 'ảnh chi tiết',
        'images.*' => 'ảnh chi tiết',

        'is_featured' => 'sản phẩm nổi bật',
        'on_sale' => 'sản phẩm giảm giá',

        // Order
        'total_price' => 'tổng tiền',
        'payment_method' => 'phương thức thanh toán',
    ],
];

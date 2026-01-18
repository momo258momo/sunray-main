<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    /* ================== ORDER STATUS ================== */
    const PENDING          = 'pending';          // Chờ xác nhận
    const CONFIRMED        = 'confirmed';        // Đã xác nhận
    const SHIPPING         = 'shipping';         // Đang giao
    const DELIVERED        = 'delivered';        // Đã giao (có thể trả hàng)

    // Trả hàng
    const RETURN_PENDING   = 'return_pending';   // Chờ duyệt trả hàng
    const RETURN_APPROVED  = 'return_approved';  // Trả hàng được duyệt
    const RETURN_REJECTED  = 'return_rejected';  // Trả hàng bị từ chối

    // Kết thúc
    const COMPLETED        = 'completed';        // Hoàn thành
    const CANCELLED        = 'cancelled';        // Đã huỷ

    /* ================== LABEL ================== */
    public static function getStatusLabels(): array
    {
        return [
            self::PENDING         => 'Chờ xác nhận',
            self::CONFIRMED       => 'Đã xác nhận',
            self::SHIPPING        => 'Đang giao hàng',
            self::DELIVERED       => 'Đã giao hàng',

            self::RETURN_PENDING  => 'Chờ duyệt trả hàng',
            self::RETURN_APPROVED => 'Trả hàng được duyệt',
            self::RETURN_REJECTED => 'Trả hàng bị từ chối',

            self::COMPLETED       => 'Hoàn thành',
            self::CANCELLED       => 'Đã huỷ',
        ];
    }

    public function getStatusLabelAttribute(): string
    {
        return self::getStatusLabels()[$this->status] ?? 'Không xác định';
    }

    /* ================== FINAL STATE ================== */
    public function isFinal(): bool
    {
        return in_array($this->status, [
            self::COMPLETED,
            self::CANCELLED,
        ]);
    }

    /* ================== FLOW TRẠNG THÁI ================== */
    public function nextAllowedStatuses(): array
    {
        return match ($this->status) {
            self::PENDING   => [self::CONFIRMED, self::CANCELLED],
            self::CONFIRMED => [self::SHIPPING, self::CANCELLED],
            self::SHIPPING  => [self::DELIVERED],

            // User gửi trả hàng
            self::DELIVERED => [self::RETURN_PENDING, self::COMPLETED],

            // Admin xử lý
            self::RETURN_PENDING => [
                self::RETURN_APPROVED,
                self::RETURN_REJECTED
            ],

            self::RETURN_APPROVED => [self::COMPLETED],
            self::RETURN_REJECTED => [self::COMPLETED],

            default => [],
        };
    }

    /* ================== RELATIONSHIPS ================== */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)
                    ->select(['id', 'first_name', 'last_name']);
    }

    /* ================== FACTORY ================== */
    public static function createOrder(array $data): self
    {
        return self::create($data);
    }
}

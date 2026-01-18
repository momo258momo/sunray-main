<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    // Use guarded = [] to allow mass assignment of all attributes
    protected $guarded = [];

    // Order status constants
    const PENDING    = 'pending';
    const CONFIRMED  = 'confirmed';
    const SHIPPING   = 'shipping';
    const DELIVERED  = 'delivered';
    const CANCELLED  = 'cancelled';
    const RETURNED   = 'returned';

    /**
     * Return a mapping of status codes to human-readable labels
     */
    public static function getStatusLabels(): array
    {
        return [
            self::PENDING    => 'Chờ xác nhận',
            self::CONFIRMED  => 'Đã xác nhận',
            self::SHIPPING   => 'Đang giao hàng',
            self::DELIVERED  => 'Hoàn thành',
            self::CANCELLED  => 'Đã hủy',
            self::RETURNED   => 'Đã trả hàng',
        ];
    }

    /**
     * Accessor for human-readable status
     */
    public function getStatusLabelAttribute(): string
    {
        return self::getStatusLabels()[$this->status] ?? 'Không xác định';
    }

    /**
     * Check if the order is in a final state
     */
    public function isFinal(): bool
    {
        return in_array($this->status, [
            self::DELIVERED,
            self::CANCELLED,
            self::RETURNED
        ]);
    }

    /**
     * Return allowed next statuses based on current status
     */
    public function nextAllowedStatuses(): array
    {
        return match ($this->status) {
            self::PENDING   => [self::CONFIRMED, self::CANCELLED],
            self::CONFIRMED => [self::SHIPPING, self::CANCELLED],
            self::SHIPPING  => [self::DELIVERED, self::RETURNED],
            default         => [],
        };
    }

    /**
     * Relationship: order has many order items
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Relationship: order belongs to a user
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)
                    ->select(['id', 'first_name', 'last_name']);
    }

    /**
     * Custom static method to create a new order
     * Example usage: Order::createOrder(['user_id' => 1, 'status' => Order::PENDING]);
     */
    public static function createOrder(array $data): self
    {
        return self::create($data);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'pending';

    public const STATUS_PAID = 'paid';

    public const STATUS_FAILED = 'failed';

    public const STATUS_REFUNDED = 'refunded';

    protected $fillable = [
        'user_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'currency',
        'total',
        'status',
        'reference_number',
        'redirect_url',
        'gateway_response',
        'items',
        'paid_at',
        'failed_at',
        'failure_reason',
    ];

    protected function casts(): array
    {
        return [
            'items' => 'array',
            'gateway_response' => 'array',
            'total' => 'decimal:2',
            'paid_at' => 'datetime',
            'failed_at' => 'datetime',
        ];
    }

    /**
     * ULIDs are lexicographically sortable, so a plain auto-increment id is
     * not needed as the public identifier and this is safe to hand to the
     * payment gateway as the merchant reference.
     */
    public static function newUlid(): string
    {
        return (string) Str::ulid();
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function isPaid(): bool
    {
        return $this->status === self::STATUS_PAID;
    }

    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isFailed(): bool
    {
        return $this->status === self::STATUS_FAILED;
    }

    /**
     * Idempotent transition into a terminal state. The return URL, the webhook
     * and a manual reconciliation can all fire for the same payment; only the
     * first may set `paid_at`, otherwise the settlement timestamp drifts to
     * whenever the customer happened to reload the page.
     */
    public function markPaid(?array $gatewayResponse = null): void
    {
        if ($this->isPaid()) {
            return;
        }

        $this->forceFill([
            'status' => self::STATUS_PAID,
            'paid_at' => now(),
            'failed_at' => null,
            'failure_reason' => null,
        ]);

        if ($gatewayResponse !== null) {
            $this->gateway_response = $gatewayResponse;
        }

        $this->save();
    }

    public function markFailed(?string $reason = null): void
    {
        if ($this->isPaid()) {
            // A settled order must never be walked back by a later poll.
            return;
        }

        $this->forceFill([
            'status' => self::STATUS_FAILED,
            'failed_at' => now(),
            'failure_reason' => $reason,
        ])->save();
    }

    protected static function booted(): void
    {
        static::creating(function (self $order): void {
            $order->ulid ??= static::newUlid();
        });
    }

    /**
     * Order totals are money, not text: always present back to the customer
     * and to the gateway with two decimal places.
     */
    public function getFormattedTotalAttribute(): string
    {
        return number_format((float) $this->total, 2);
    }
}

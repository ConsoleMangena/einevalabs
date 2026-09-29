<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $quantity = fake()->numberBetween(1, 3);
        $unitPrice = fake()->randomFloat(2, 10, 500);

        $line = [
            'product_id' => null,
            'name' => fake()->words(3, true),
            'slug' => fake()->slug(),
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'line_total' => round($unitPrice * $quantity, 2),
        ];

        return [
            'user_id' => null,
            'customer_name' => fake()->name(),
            'customer_email' => fake()->safeEmail(),
            'customer_phone' => null,
            'currency' => 'USD',
            'total' => $line['line_total'],
            'status' => Order::STATUS_PENDING,
            'reference_number' => strtoupper(fake()->bothify('REF-####-????')),
            'items' => [$line],
        ];
    }

    public function paid(): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => Order::STATUS_PAID,
            'paid_at' => now(),
            'failed_at' => null,
            'failure_reason' => null,
        ]);
    }

    public function failed(?string $reason = null): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => Order::STATUS_FAILED,
            'failed_at' => now(),
            'failure_reason' => $reason ?? 'Failed in test.',
        ]);
    }

    public function pending(): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => Order::STATUS_PENDING,
            'paid_at' => null,
            'failed_at' => null,
            'failure_reason' => null,
        ]);
    }
}

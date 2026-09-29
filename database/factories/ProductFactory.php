<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->words(3, true);

        return [
            'name' => Str::title($name),
            'slug' => Str::slug($name).'-'.fake()->unique()->numberBetween(1, 999999),
            'category' => fake()->randomElement(['Workstations', 'Comms', 'Lab Hardware', 'Apparel & Accessories']),
            'description' => fake()->paragraph(),
            'price' => fake()->randomFloat(2, 50, 5000),
            'specs' => [
                'Weight' => fake()->numberBetween(100, 5000).' g',
            ],
            'image_url' => 'products/'.Str::slug($name).'.png',
            'images' => [],
        ];
    }

    /**
     * A null price means "price on request" in the storefront, not a free
     * item. Used to prove the cart and checkout refuse to price it.
     */
    public function onRequest(): static
    {
        return $this->state(fn (array $attributes): array => [
            'price' => null,
        ]);
    }

    public function withoutImage(): static
    {
        return $this->state(fn (array $attributes): array => [
            'image_url' => null,
        ]);
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $sellPrice = $this->faker->numberBetween(1, 1000);
        $costPrice = $this->faker->numberBetween(1, $sellPrice - 1);
        return [
            'code' => sprintf("%06d", mt_rand(1, 999999)),
            'product_name' => $this->faker->word(),
            'supplier_name' => $this->faker->word(),
            'quantity' => $this->faker->numberBetween(1, 100),
            'unit' => $this->faker->randomElement(['kg', 'g', 'l', 'ml', 'pcs']),
            'sell_price' => $sellPrice,
            'cost_price' => $costPrice,
            'category_id' => $this->faker->numberBetween(1, 10),
        ];
    }
}

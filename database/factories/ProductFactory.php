<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Product;
use Faker\Generator as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class ProductFactory extends Factory{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->text(50),
            'description' => $this->faker->text(200),
            'brand_id' => 1,
            'slug' => $this->faker->slug(),
            'sku' => $this->faker->unique()->isbn10(),
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'special_price' => $this->faker->randomFloat(2, 10, 1000),
            'special_price_type' => $this->faker->randomElement(['fixed', 'percentage']),
            'special_price_start' => $this->faker->dateTimeBetween('-1 month', '+1 month'),
            'special_price_end' => $this->faker->dateTimeBetween('+1 month', '+2 month'),
            'selling_price' => $this->faker->randomFloat(2, 10, 1000),
            'manage_stock' => $this->faker->boolean(),
            'quantity' => $this->faker->numberBetween(0, 100),
            'in_stock' => $this->faker->boolean(),
            'is_active' => $this->faker->boolean(),
        ];
    }
}

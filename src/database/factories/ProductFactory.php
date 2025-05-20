<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $image = [
            'fruits/kiwi.png',
            'fruits/strawberry.png',
            'fruits/orange.png',
            'fruits/watermelon.png',
            'fruits/peach.png',
            'fruits/grape.png',
        ];

        return [
            'name' => $this->faker->randomElement(['キウイ', 'ストロベリー', 'オレンジ', 'スイカ', 'ピーチ', 'シャインマスカット']),
            'price' => $this->faker->numberBetween(500, 1500),
            'image' => $this->faker->randomElement($image),
        ];
    }
}

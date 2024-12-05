<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'category' => fake()->randomElement(['Candles', 'Clocks', 'Jewelry']),
            // 'category' => fake()->randomElement(['Coasters', 'Planters', 'Candles', 'Clocks', 'Jewelry']),
            'collection' => fake()->randomElement(['Haus', 'Brut', 'Inspira', 'Terrazzo']),
            // 'collection' => fake()->randomElement(['Haus', 'Brut', 'Inspira', 'Terrazzo', 'Candle']),
            'color' => fake()->colorName(),
            'price' => fake()->numberBetween(50, 150),
            'description' => fake()->paragraph(5),
            'dimension' => fake()->numberBetween(10, 50),
            'thickness' => fake()->numberBetween(10, 50),
            'location_made' => fake()->country(),
            'image_url' => fake()->randomElement(['https://collagestudio.ca/uploads/products/Haus_Collection/Thumbs/COL-Chandelle-Pomme-Granade.jpg'])
        ];
    }
}

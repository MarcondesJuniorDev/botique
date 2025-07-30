<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'brand' => $this->faker->randomElement(['Avon', 'Natura', 'Boticário']),
            'description' => $this->faker->sentence(5, true),
            'sku' => $this->faker->unique()->regexify('[A-Z0-9]{6}'),
            'price' => $this->faker->randomFloat(2, 20, 300),
            'cost_price' => $this->faker->randomFloat(2, 20, 300),
            'stock' => $this->faker->numberBetween(0, 100),
            'image' => $this->faker->imageUrl(640, 480, 'products', true),
            'category_id' => \App\Models\Category::inRandomOrder()->value('id'),
        ];
    }
}

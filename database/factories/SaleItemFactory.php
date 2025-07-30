<?php

namespace Database\Factories;

use App\Models\SaleItem;
use App\Models\Sale;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class SaleItemFactory extends Factory
{
    protected $model = SaleItem::class;

    public function definition()
    {
        return [
            'sale_id' => Sale::inRandomOrder()->first()->id ?? Sale::factory(),
            'product_id' => Product::inRandomOrder()->first()->id ?? Product::factory(),
            'quantity' => $this->faker->numberBetween(1, 100),
            'unit_price' => $this->faker->randomFloat(2, 10, 500),
        ];
    }
}

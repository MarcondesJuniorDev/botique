<?php

namespace Database\Factories;

use App\Models\PurchaseItem;
use App\Models\Purchase;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class PurchaseItemFactory extends Factory
{
    protected $model = PurchaseItem::class;

    public function definition()
    {
        return [
            'purchase_id' => Purchase::inRandomOrder()->first()->id ?? Purchase::factory(),
            'product_id' => Product::inRandomOrder()->first()->id ?? Product::factory(),
            'quantity' => $this->faker->numberBetween(1, 100),
            'unit_cost' => $this->faker->randomFloat(2, 10, 500),
        ];
    }
}

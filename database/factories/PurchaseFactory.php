<?php

namespace Database\Factories;

use App\Models\Purchase;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

class PurchaseFactory extends Factory
{
    protected $model = Purchase::class;

    public function definition()
    {
        return [
            'supplier_id' => Supplier::factory(),
            'purchase_date' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'total_amount' => $this->faker->randomFloat(2, 100, 10000),
            'status' => $this->faker->randomElement(['pendente', 'concluido', 'cancelado']),
            'notes' => $this->faker->optional()->paragraph,
        ];
    }
}

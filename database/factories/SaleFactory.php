<?php

namespace Database\Factories;

use App\Models\Sale;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class SaleFactory extends Factory
{
    protected $model = Sale::class;

    public function definition()
    {
        return [
            'customer_id' => Customer::inRandomOrder()->first()->id ?? Customer::factory(),
            'sale_date' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'total_amount' => $this->faker->randomFloat(2, 100, 10000),
            'payment_method' => $this->faker->randomElement(['cartao_credito', 'cartao_debito', 'dinheiro', 'pix']),
            'notes' => $this->faker->optional()->sentence,
        ];
    }
}

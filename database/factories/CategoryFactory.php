<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition()
    {
        return [
            'name' => $this->faker->randomElement([
                'Perfumaria',
                'Maquiagem',
                'Cuidados com a Pele',
                'Higiene Pessoal',
                'Cabelos',
                'Unhas',
                'Acessórios',
                'Cuidados Corporais'
            ]),
            'description' => match ($this->faker->lastName) {
                default => match ($name = $this->faker->randomElement([
                    'Perfumaria',
                    'Maquiagem',
                    'Cuidados com a Pele',
                    'Higiene Pessoal',
                    'Cabelos',
                    'Unhas',
                    'Acessórios',
                    'Cuidados Corporais'
                ])) {
                    'Perfumaria' => 'Produtos para perfumar e aromatizar.',
                    'Maquiagem' => 'Itens para realçar a beleza facial.',
                    'Cuidados com a Pele' => 'Produtos para manter a pele saudável.',
                    'Higiene Pessoal' => 'Itens para higiene diária.',
                    'Cabelos' => 'Produtos para cuidados capilares.',
                    'Unhas' => 'Produtos para unhas bonitas e saudáveis.',
                    'Acessórios' => 'Acessórios para complementar o visual.',
                    'Cuidados Corporais' => 'Produtos para cuidados do corpo.',
                    default => 'Categoria de produtos de beleza.',
                }
            },
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition()
    {
        $categories = [
            [
                "name" => "Perfumaria",
                "description" => "Produtos para perfumar e aromatizar."
            ],
            [
                "name" => "Maquiagem",
                "description" => "Itens para realçar a beleza facial."
            ],
            [
                "name" => "Cuidados com a Pele",
                "description" => "Produtos para manter a pele saudável."
            ],
            [
                "name" => "Higiene Pessoal",
                "description" => "Itens para higiene diária."
            ],
            [
                "name" => "Cabelos",
                "description" => "Produtos para cuidados capilares."
            ],
            [
                "name" => "Unhas",
                "description" => "Produtos para unhas bonitas e saudáveis."
            ],
            [
                "name" => "Acessórios",
                "description" => "Acessórios para complementar o visual."
            ],
            [
                "name" => "Cuidados Corporais",
                "description" => "Produtos para cuidados do corpo."
            ]
        ];

        // Retorna um item aleatório do array de categorias
        return $this->faker->unique()->randomElement($categories);
    }
}

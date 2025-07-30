<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\Category;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CustomSeeder::class
        ]);

        // Criação de clientes
        Customer::factory(10)->create();

        // Criação de fornecedores
        Supplier::factory(10)->create();

        // Criação de categorias
        Category::factory(8)->create();

        // Criação de produtos
        Product::factory(20)->create();

        // Criação de compras
        Purchase::factory(10)->create()->each(function ($purchase) {
            PurchaseItem::factory(3)->create(['purchase_id' => $purchase->id]);
        });

        // Criação de vendas
        Sale::factory(10)->create()->each(function ($sale) {
            SaleItem::factory(3)->create(['sale_id' => $sale->id]);
        });
    }
}

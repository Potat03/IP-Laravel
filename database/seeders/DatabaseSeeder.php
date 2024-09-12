<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Promotion;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Customer::create([
            'username' => 'customer1',
            'tier' => 'gold',
            'phone_number' => '081234567890',
            'email' => 'customer@gmail.com',
            'password' => 'password',
            'status' => 'active',
        ]);

        Product::create([
            'name' => 'product1',
            'description' => 'product1 description',
            'price' => '10000',
            'stock' => '10',
            'status' => 'active',
        ]);

        Product::create([
            'name' => 'product2',
            'description' => 'product2 description',
            'price' => '1000',
            'stock' => '50',
            'status' => 'active',
        ]);

        Product::create([
            'name' => 'product3',
            'description' => 'product3 description',
            'price' => '1000',
            'stock' => '50',
            'status' => 'inactive',
        ]);

        Product::create([
            'name' => 'product4',
            'description' => 'product4 description',
            'price' => '1000',
            'stock' => '0',
            'status' => 'active',
        ]);

        Cart::create([
            'customer_id' => '1',
            'subtotal' => '10000',
            'total_discount' => '0',
            'total' => '10000',
        ]);

        Promotion::create([
            'title' => 'promotion1',
            'description' => 'promotion1 description',
            'discount' => '10%',
            'discount_amount' => '1000',
            'original_price' => '10000',
            'type' => 'single',
            'limit' => '10000',
            'start_at' => '2024-07-28',
            'end_at' => '2024-07-30',
            'status' => 'active',
        ]);

        Promotion::create([
            'title' => 'promotion2',
            'description' => 'promotion2 description',
            'discount' => '1000',
            'discount_amount' => '1000',
            'original_price' => '10000',
            'type' => 'bundle',
            'limit' => '10000',
            'start_at' => '2024-07-28',
            'end_at' => '2024-07-30',
            'status' => 'active',
        ]);

    }
}

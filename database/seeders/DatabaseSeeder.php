<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Promotion;
use App\Models\PromotionItem;
use App\Models\Wearable;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Admin;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use function Symfony\Component\String\b;

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
            'password' =>  bcrypt('password'),
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

        Wearable::create([
            'product_id' => '1',
            'size' => 'M,L,XL',
            'color' => 'black,white',
            'user_group' => 'men'
        ]);

        Wearable::create([
            'product_id' => '2',
            'size' => 'M,L,XL',
            'color' => 'black,green',
            'user_group' => 'men'
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
            'discount' => '10',
            'discount_amount' => '1000',
            'original_price' => '10000',
            'type' => 'single',
            'limit' => '10000',
            'start_at' => '2024-07-28',
            'end_at' => '2024-07-30',
            'status' => 'active',
        ]);

        PromotionItem::create([
            'promotion_id' => '1',
            'product_id' => '1',
            'quantity' => '1',
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

        PromotionItem::create([
            'promotion_id' => '2',
            'product_id' => '1',
            'quantity' => '2',
        ]);

        PromotionItem::create([
            'promotion_id' => '2',
            'product_id' => '2',
            'quantity' => '1',
        ]);

        Order::create([
            'customer_id' => '1',
            'subtotal' => '10000',
            'total_discount' => '0',
            'total' => '10000',
            'status' => 'pending',
            'delivery_address' => 'Jl. Raya Bogor',
            'delivery_method' => 'JNE',
            'tracking_number' => '1234567890',
        ]);

        OrderItem::create([
            'order_id' => '1',
            'promotion_id' => '1',
            'quantity' => '1',
            'subtotal' => '10000',
            'discount' => '0',
            'total' => '10000',
        ]);

        Admin::create([
            'role' => 'manager',
            'email' => 'test@gmail.com',
            'password' =>  '$2y$12$SPXDqYIUQGznYrtl7pxsAet5RAxKZhVb6r.9aEgylQlbP2DI89mJO',
            'status' => 'active',
        ]);


        
    }
}

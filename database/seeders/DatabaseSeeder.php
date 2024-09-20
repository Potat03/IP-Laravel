<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Promotion;
use App\Models\PromotionItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Admin;
use App\Models\Wearable;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed Customers
        Customer::create([
            'username' => 'customer1',
            'tier' => 'gold',
            'phone_number' => '081234567890',
            'email' => 'customer1@gmail.com',
            'password' => bcrypt('password'),
            'status' => 'active',
        ]);

        Customer::create([
            'username' => 'customer2',
            'tier' => 'silver',
            'phone_number' => '082345678901',
            'email' => 'customer2@gmail.com',
            'password' => bcrypt('password'),
            'status' => 'active',
        ]);

        // Seed Products
        Product::create([
            'name' => 'product1',
            'description' => 'Product 1 description',
            'price' => '100',
            'stock' => '10',
            'status' => 'active',
        ]);

        Product::create([
            'name' => 'product2',
            'description' => 'Product 2 description',
            'price' => '200',
            'stock' => '20',
            'status' => 'active',
        ]);

        Product::create([
            'name' => 'product3',
            'description' => 'Product 3 description',
            'price' => '300',
            'stock' => '30',
            'status' => 'active',
        ]);

        Product::create([
            'name' => 'product4',
            'description' => 'Product 4 description',
            'price' => '400',
            'stock' => '40',
            'status' => 'active',
        ]);

        // Seed Wearables
        Wearable::create([
            'product_id' => 1,
            'size' => 'M,L,XL',
            'color' => 'black,white',
            'user_group' => 'men'
        ]);

        Wearable::create([
            'product_id' => 2,
            'size' => 'S,M,L',
            'color' => 'blue,red',
            'user_group' => 'women'
        ]);

        // Seed Carts
        Cart::create([
            'customer_id' => 1,
            'subtotal' => '3000',
            'delivery_fee' => '50',
            'total_discount' => '500',
            'total' => '2550',
        ]);

        Cart::create([
            'customer_id' => 2,
            'subtotal' => '5000',
            'delivery_fee' => '100',
            'total_discount' => '1000',
            'total' => '4100',
        ]);

        // Seed Promotions
        Promotion::create([
            'title' => 'Summer Sale',
            'description' => 'Discount on summer collection',
            'discount' => '20',
            'discount_amount' => '200',
            'original_price' => '1000',
            'type' => 'percentage',
            'limit' => '50',
            'status' => 'active',
            'start_at' => Carbon::now(),
            'end_at' => Carbon::now()->addDays(30),
        ]);

        Promotion::create([
            'title' => 'Winter Sale',
            'description' => 'Discount on winter collection',
            'discount' => '30',
            'discount_amount' => '300',
            'original_price' => '1500',
            'type' => 'percentage',
            'limit' => '30',
            'status' => 'active',
            'start_at' => Carbon::now(),
            'end_at' => Carbon::now()->addDays(60),
        ]);

        // Seed Promotion Items
        PromotionItem::create([
            'promotion_id' => 1,
            'product_id' => 1,
            'quantity' => 2,
        ]);

        PromotionItem::create([
            'promotion_id' => 1,
            'product_id' => 2,
            'quantity' => 1,
        ]);

        PromotionItem::create([
            'promotion_id' => 2,
            'product_id' => 3,
            'quantity' => 3,
        ]);

        PromotionItem::create([
            'promotion_id' => 2,
            'product_id' => 4,
            'quantity' => 1,
        ]);

        // Seed Orders
        Order::create([
            'customer_id' => 1,
            'subtotal' => '5000',
            'total_discount' => '1000',
            'total' => '4000',
            'status' => 'completed',
            'delivery_address' => 'Jl. Raya Bogor',
            'delivery_method' => 'JNE',
            'tracking_number' => '1234567890',
            'created_at' => Carbon::now()->subDays(35),
            'updated_at' => Carbon::now()->subDays(35),
        ]);

        Order::create([
            'customer_id' => 2,
            'subtotal' => '3000',
            'total_discount' => '500',
            'total' => '2500',
            'status' => 'pending',
            'delivery_address' => 'Jl. Raya Jakarta',
            'delivery_method' => 'JNE',
            'tracking_number' => '0987654321',
            'created_at' => Carbon::now()->subDays(5),
            'updated_at' => Carbon::now()->subDays(5),
        ]);

        // Seed Order Items
        OrderItem::create([
            'order_id' => 1,
            'promotion_id' => 1,
            'product_id' => 1,
            'quantity' => 2,
            'subtotal' => '2000',
            'discount' => '200',
            'total' => '1800',
            'created_at' => Carbon::now()->subDays(35),
            'updated_at' => Carbon::now()->subDays(35),
        ]);

        OrderItem::create([
            'order_id' => 1,
            'promotion_id' => 2,
            'product_id' => 2,
            'quantity' => 2,
            'subtotal' => '4000',
            'discount' => '800',
            'total' => '3200',
            'created_at' => Carbon::now()->subDays(35),
            'updated_at' => Carbon::now()->subDays(35),
        ]);

        OrderItem::create([
            'order_id' => 2,
            'promotion_id' => 1,
            'product_id' => 3,
            'quantity' => 1,
            'subtotal' => '1500',
            'discount' => '150',
            'total' => '1350',
        ]);

        OrderItem::create([
            'order_id' => 2,
            'promotion_id' => 2,
            'product_id' => 4,
            'quantity' => 1,
            'subtotal' => '400',
            'discount' => '120',
            'total' => '280',
        ]);

        // Seed Admins
        Admin::create([
            'name' => 'Manager',
            'role' => 'manager',
            'email' => 'manager@gmail.com',
            'password' => bcrypt('managerpassword'),
            'status' => 'active',
        ]);

        Admin::create([
            'name' => 'Admin 1',
            'role' => 'admin',
            'email' => 'admin1@gmail.com',
            'password' => bcrypt('adminpassword'),
            'status' => 'active',
        ]);

        Admin::create([
            'name' => 'Admin 2',
            'role' => 'admin',
            'email' => 'admin2@gmail.com',
            'password' => bcrypt('adminpassword'),
            'status' => 'active',
        ]);

        Admin::create([
            'name' => 'Customer Service 1',
            'role' => 'customer_service',
            'email' => 'cs1@gmail.com',
            'password' => bcrypt('customerpassword'),
            'status' => 'active',
        ]);

        Admin::create([
            'name' => 'Customer Service 2',
            'role' => 'customer_service',
            'email' => 'cs2@gmail.com',
            'password' => bcrypt('customerpassword'),
            'status' => 'active',
        ]);
    }
}

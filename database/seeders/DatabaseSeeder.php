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
use App\Models\Chat;
use App\Models\ChatMessage; 
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
            'status' => 'delivered',
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
            'status' => 'delivery',
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

        CartItem::create([
            'customer_id'=>1,
            'product_id'=>1,
            'promotion_id'=>null,
            'quantity'=>2,
            'details'=>'black',
            'subtotal'=>200.00,
            'discount'=>0,
            'total'=>200,
        ]);

        CartItem::create([
            'customer_id'=>1,
            'product_id'=>null,
            'promotion_id'=>2,
            'quantity'=>2,
            'details'=>'black',
            'subtotal'=>3000.00,
            'discount'=>600,
            'total'=>2400,
        ]);

        Chat::create([
            'customer_id'=>1,
            'admin_id'=>5,
            'status'=>'ended',
            'rating'=>5,
            'accepted_at'=>'2024-09-22 19:34:33',
            'ended_at'=>'2024-09-22 19:35:54',
            'created_at'=>'2024-09-22 19:34:10'
        ]);
        
        Chat::create([
            'customer_id'=>2,
            'admin_id'=>4,
            'status'=>'ended',
            'rating'=>1,
            'accepted_at'=>'2024-09-22 19:34:17',
            'ended_at'=>'2024-09-22 19:36:09',
            'created_at'=>'2024-09-22 19:34:12'
        ]);
        
        Chat::create([
            'customer_id'=>1,
            'admin_id'=>5,
            'status'=>'ended',
            'rating'=>4,
            'accepted_at'=>'2024-09-22 19:36:33',
            'ended_at'=>'2024-09-22 19:37:05',
            'created_at'=>'2024-09-22 19:36:17'
        ]);
        
        Chat::create([
            'customer_id'=>2,
            'admin_id'=>4,
            'status'=>'ended',
            'rating'=>2,
            'accepted_at'=>'2024-09-22 19:36:30',
            'ended_at'=>'2024-09-22 19:37:01',
            'created_at'=>'2024-09-22 19:36:21'
        ]);
        
        Chat::create([
            'customer_id'=>1,
            'admin_id'=>5,
            'status'=>'ended',
            'rating'=>4,
            'accepted_at'=>'2024-09-22 19:37:24',
            'ended_at'=>'2024-09-22 19:38:28',
            'created_at'=>'2024-09-22 19:37:12'
        ]);
        
        Chat::create([
            'customer_id'=>2,
            'admin_id'=>4,
            'status'=>'ended',
            'rating'=>3,
            'accepted_at'=>'2024-09-22 19:37:22',
            'ended_at'=>'2024-09-22 19:38:26',
            'created_at'=>'2024-09-22 19:37:15'
        ]);
        
        Chat::create([
            'customer_id'=>1,
            'admin_id'=>5,
            'status'=>'ended',
            'rating'=>3,
            'accepted_at'=>'2024-09-22 19:45:21',
            'ended_at'=>'2024-09-22 19:45:59',
            'created_at'=>'2024-09-22 19:45:18'
        ]);
        
        Chat::create([
            'customer_id'=>2,
            'admin_id'=>5,
            'status'=>'ended',
            'rating'=>4,
            'accepted_at'=>'2024-09-22 19:45:28',
            'ended_at'=>'2024-09-22 19:46:01',
            'created_at'=>'2024-09-22 19:45:25'
        ]);
        
        Chat::create([
            'customer_id'=>2,
            'admin_id'=>5,
            'status'=>'ended',
            'rating'=>4,
            'accepted_at'=>'2024-09-22 19:47:30',
            'ended_at'=>'2024-09-22 19:49:34',
            'created_at'=>'2024-09-22 19:46:10'
        ]);
        
        Chat::create([
            'customer_id'=>1,
            'admin_id'=>5,
            'status'=>'ended',
            'rating'=>5,
            'accepted_at'=>'2024-09-22 19:47:29',
            'ended_at'=>'2024-09-22 19:49:37',
            'created_at'=>'2024-09-22 19:46:12'
        ]);
        
        Chat::create([
            'customer_id'=>1,
            'admin_id'=>4,
            'status'=>'ended',
            'rating'=>4,
            'accepted_at'=>'2024-09-22 19:52:31',
            'ended_at'=>'2024-09-22 19:52:44',
            'created_at'=>'2024-09-22 19:52:25'
        ]);
        
        Chat::create([
            'customer_id'=>1,
            'admin_id'=>4,
            'status'=>'ended',
            'rating'=>4,
            'accepted_at'=>'2024-09-22 19:55:15',
            'ended_at'=>'2024-09-22 19:55:26',
            'created_at'=>'2024-09-22 19:55:11'
        ]);
        
        Chat::create([
            'customer_id'=>2,
            'admin_id'=>4,
            'status'=>'ended',
            'rating'=>4,
            'accepted_at'=>'2024-09-22 19:58:13',
            'ended_at'=>'2024-09-22 19:58:15',
            'created_at'=>'2024-09-22 19:58:10'
        ]);
        
        Chat::create([
            'customer_id'=>2,
            'admin_id'=>4,
            'status'=>'ended',
            'rating'=>4,
            'accepted_at'=>'2024-09-22 19:58:29',
            'ended_at'=>'2024-09-22 19:59:29',
            'created_at'=>'2024-09-22 19:58:25'
        ]);
        
        Chat::create([
            'customer_id'=>2,
            'admin_id'=>4,
            'status'=>'ended',
            'rating'=>5,
            'accepted_at'=>'2024-09-22 20:00:02',
            'ended_at'=>'2024-09-22 20:00:07',
            'created_at'=>'2024-09-22 19:59:43'
        ]);
        
        Chat::create([
            'customer_id'=>1,
            'admin_id'=>5,
            'status'=>'ended',
            'rating'=>2,
            'accepted_at'=>'2024-09-22 20:00:50',
            'ended_at'=>'2024-09-22 20:00:58',
            'created_at'=>'2024-09-22 20:00:47'
        ]);
        
        Chat::create([
            'customer_id'=>1,
            'admin_id'=>4,
            'status'=>'ended',
            'rating'=>4,
            'accepted_at'=>'2024-09-22 20:02:12',
            'ended_at'=>'2024-09-22 20:02:13',
            'created_at'=>'2024-09-22 20:02:03'
        ]);
        
        Chat::create([
            'customer_id'=>1,
            'admin_id'=>4,
            'status'=>'ended',
            'rating'=>4,
            'accepted_at'=>'2024-09-22 20:05:33',
            'ended_at'=>'2024-09-22 20:05:35',
            'created_at'=>'2024-09-22 20:05:29'
        ]);

        ChatMessage::create([
            'chat_id'=>1,
            'by_customer'=>1,
            'message_content'=>'1',
            'message_type'=>'product',
            'created_at'=>'2024-09-22 19:34:10'
        ]);
        
        ChatMessage::create([
            'chat_id'=>2,
            'by_customer'=>1,
            'message_content'=>'hello',
            'message_type'=>'text',
            'created_at'=>'2024-09-22 19:34:14'
        ]);
        
        ChatMessage::create([
            'chat_id'=>2,
            'by_customer'=>0,
            'message_content'=>'hi',
            'message_type'=>'text',
            'created_at'=>'2024-09-22 19:34:26'
        ]);
        
        ChatMessage::create([
            'chat_id'=>2,
            'by_customer'=>1,
            'message_content'=>'bye',
            'message_type'=>'text',
            'created_at'=>'2024-09-22 19:34:31'
        ]);
        
        ChatMessage::create([
            'chat_id'=>1,
            'by_customer'=>0,
            'message_content'=>'hello',
            'message_type'=>'text',
            'created_at'=>'2024-09-22 19:34:36'
        ]);
        
        ChatMessage::create([
            'chat_id'=>1,
            'by_customer'=>1,
            'message_content'=>'bebebebebe',
            'message_type'=>'text',
            'created_at'=>'2024-09-22 19:34:42'
        ]);
        
        ChatMessage::create([
            'chat_id'=>1,
            'by_customer'=>0,
            'message_content'=>'how can i help you ?',
            'message_type'=>'text',
            'created_at'=>'2024-09-22 19:35:10'
        ]);
        
        ChatMessage::create([
            'chat_id'=>1,
            'by_customer'=>1,
            'message_content'=>'how much is this product',
            'message_type'=>'text',
            'created_at'=>'2024-09-22 19:35:24'
        ]);
        
        ChatMessage::create([
            'chat_id'=>1,
            'by_customer'=>0,
            'message_content'=>'RM100 each',
            'message_type'=>'text',
            'created_at'=>'2024-09-22 19:35:35'
        ]);
        
        ChatMessage::create([
            'chat_id'=>1,
            'by_customer'=>1,
            'message_content'=>'ok can 88',
            'message_type'=>'text',
            'created_at'=>'2024-09-22 19:35:41'
        ]);
        
        ChatMessage::create([
            'chat_id'=>1,
            'by_customer'=>0,
            'message_content'=>"you're welcome",
            'message_type'=>'text',
            'created_at'=>'2024-09-22 19:35:51'
        ]);
        
        ChatMessage::create([
            'chat_id'=>2,
            'by_customer'=>1,
            'message_content'=>'help me',
            'message_type'=>'text',
            'created_at'=>'2024-09-22 19:36:05'
        ]);
        
        ChatMessage::create([
            'chat_id'=>2,
            'by_customer'=>0,
            'message_content'=>'no',
            'message_type'=>'text',
            'created_at'=>'2024-09-22 19:36:07'
        ]);
        
        ChatMessage::create([
            'chat_id'=>3,
            'by_customer'=>1,
            'message_content'=>'hi again',
            'message_type'=>'text',
            'created_at'=>'2024-09-22 19:36:18'
        ]);
        
        ChatMessage::create([
            'chat_id'=>4,
            'by_customer'=>1,
            'message_content'=>'bye again',
            'message_type'=>'text',
            'created_at'=>'2024-09-22 19:36:22'
        ]);
        
        ChatMessage::create([
            'chat_id'=>3,
            'by_customer'=>0,
            'message_content'=>'hello again',
            'message_type'=>'text',
            'created_at'=>'2024-09-22 19:36:45'
        ]);
        
        ChatMessage::create([
            'chat_id'=>5,
            'by_customer'=>1,
            'message_content'=>'Jojo',
            'message_type'=>'text',
            'created_at'=>'2024-09-22 19:37:13'
        ]);
        
        ChatMessage::create([
            'chat_id'=>6,
            'by_customer'=>1,
            'message_content'=>'Juju',
            'message_type'=>'text',
            'created_at'=>'2024-09-22 19:37:16'
        ]);
        
        ChatMessage::create([
            'chat_id'=>6,
            'by_customer'=>0,
            'message_content'=>'su kaisen',
            'message_type'=>'text',
            'created_at'=>'2024-09-22 19:37:29'
        ]);
        
        ChatMessage::create([
            'chat_id'=>5,
            'by_customer'=>0,
            'message_content'=>'Dame dame',
            'message_type'=>'text',
            'created_at'=>'2024-09-22 19:37:34'
        ]);
        
        ChatMessage::create([
            'chat_id'=>6,
            'by_customer'=>1,
            'message_content'=>'kansen :)',
            'message_type'=>'text',
            'created_at'=>'2024-09-22 19:37:41'
        ]);
        
        ChatMessage::create([
            'chat_id'=>6,
            'by_customer'=>1,
            'message_content'=>'1727005072.png',
            'message_type'=>'image',
            'created_at'=>'2024-09-22 19:37:52'
        ]);
        
        ChatMessage::create([
            'chat_id'=>6,
            'by_customer'=>0,
            'message_content'=>'wao',
            'message_type'=>'text',
            'created_at'=>'2024-09-22 19:37:59'
        ]);
        
        ChatMessage::create([
            'chat_id'=>6,
            'by_customer'=>0,
            'message_content'=>'1727005083.png',
            'message_type'=>'image',
            'created_at'=>'2024-09-22 19:38:03'
        ]);
        
        ChatMessage::create([
            'chat_id'=>7,
            'by_customer'=>1,
            'message_content'=>'ggg',
            'message_type'=>'text',
            'created_at'=>'2024-09-22 19:45:19'
        ]);
        
        ChatMessage::create([
            'chat_id'=>8,
            'by_customer'=>1,
            'message_content'=>'ffff',
            'message_type'=>'text',
            'created_at'=>'2024-09-22 19:45:26'
        ]);
        
        ChatMessage::create([
            'chat_id'=>9,
            'by_customer'=>1,
            'message_content'=>'heheh',
            'message_type'=>'text',
            'created_at'=>'2024-09-22 19:46:11'
        ]);
        
        ChatMessage::create([
            'chat_id'=>10,
            'by_customer'=>1,
            'message_content'=>'hehe',
            'message_type'=>'text',
            'created_at'=>'2024-09-22 19:46:13'
        ]);
        
        ChatMessage::create([
            'chat_id'=>9,
            'by_customer'=>0,
            'message_content'=>'1727005688.png',
            'message_type'=>'image',
            'created_at'=>'2024-09-22 19:48:08'
        ]);
        
        ChatMessage::create([
            'chat_id'=>9,
            'by_customer'=>0,
            'message_content'=>'hehehe',
            'message_type'=>'text',
            'created_at'=>'2024-09-22 19:48:22'
        ]);
        
        
        ChatMessage::create([
            'chat_id'=>9,
            'by_customer'=>0,
            'message_content'=>'1727005702.png',
            'message_type'=>'image',
            'created_at'=>'2024-09-22 19:48:22'
        ]);
        
        ChatMessage::create([
            'chat_id'=>11,
            'by_customer'=>1,
            'message_content'=>'hi',
            'message_type'=>'text',
            'created_at'=>'2024-09-22 19:52:26'
        ]);
        
        ChatMessage::create([
            'chat_id'=>11,
            'by_customer'=>0,
            'message_content'=>'23123',
            'message_type'=>'text',
            'created_at'=>'2024-09-22 19:52:38'
        ]);
        
        ChatMessage::create([
            'chat_id'=>11,
            'by_customer'=>0,
            'message_content'=>'1727005958.png',
            'message_type'=>'image',
            'created_at'=>'2024-09-22 19:52:38'
        ]);
        
        ChatMessage::create([
            'chat_id'=>12,
            'by_customer'=>1,
            'message_content'=>'hehe',
            'message_type'=>'text',
            'created_at'=>'2024-09-22 19:55:13'
        ]);
        
        ChatMessage::create([
            'chat_id'=>12,
            'by_customer'=>0,
            'message_content'=>'2323',
            'message_type'=>'text',
            'created_at'=>'2024-09-22 19:55:21'
        ]);
        
        ChatMessage::create([
            'chat_id'=>12,
            'by_customer'=>0,
            'message_content'=>'1727006121.png',
            'message_type'=>'image',
            'created_at'=>'2024-09-22 19:55:21'
        ]);
        
        ChatMessage::create([
            'chat_id'=>13,
            'by_customer'=>1,
            'message_content'=>'ggg',
            'message_type'=>'text',
            'created_at'=>'2024-09-22 19:58:11'
        ]);
        
        ChatMessage::create([
            'chat_id'=>14,
            'by_customer'=>1,
            'message_content'=>'ddddd',
            'message_type'=>'text',
            'created_at'=>'2024-09-22 19:58:27'
        ]);
        
        ChatMessage::create([
            'chat_id'=>14,
            'by_customer'=>0,
            'message_content'=>'1727006311.png',
            'message_type'=>'image',
            'created_at'=>'2024-09-22 19:58:31'
        ]);
        
        ChatMessage::create([
            'chat_id'=>14,
            'by_customer'=>0,
            'message_content'=>'sdad',
            'message_type'=>'text',
            'created_at'=>'2024-09-22 19:58:33'
        ]);
        
        ChatMessage::create([
            'chat_id'=>15,
            'by_customer'=>1,
            'message_content'=>'1727006383.png',
            'message_type'=>'image',
            'created_at'=>'2024-09-22 19:59:43'
        ]);
        
        ChatMessage::create([
            'chat_id'=>15,
            'by_customer'=>1,
            'message_content'=>'1727006390.png',
            'message_type'=>'image',
            'created_at'=>'2024-09-22 19:59:50'
        ]);
        
        ChatMessage::create([
            'chat_id'=>15,
            'by_customer'=>1,
            'message_content'=>'223',
            'message_type'=>'text',
            'created_at'=>'2024-09-22 19:59:52'
        ]);
        
        ChatMessage::create([
            'chat_id'=>16,
            'by_customer'=>1,
            'message_content'=>'Hosdd',
            'message_type'=>'text',
            'created_at'=>'2024-09-22 20:00:49'
        ]);
        
        ChatMessage::create([
            'chat_id'=>16,
            'by_customer'=>1,
            'message_content'=>'2333',
            'message_type'=>'text',
            'created_at'=>'2024-09-22 20:00:56'
        ]);
        
        ChatMessage::create([
            'chat_id'=>16,
            'by_customer'=>1,
            'message_content'=>'1727006456.png',
            'message_type'=>'image',
            'created_at'=>'2024-09-22 20:00:56'
        ]);
        
        ChatMessage::create([
            'chat_id'=>17,
            'by_customer'=>1,
            'message_content'=>'ffff',
            'message_type'=>'text',
            'created_at'=>'2024-09-22 20:02:04'
        ]);
        
        ChatMessage::create([
            'chat_id'=>17,
            'by_customer'=>1,
            'message_content'=>'sddd',
            'message_type'=>'text',
            'created_at'=>'2024-09-22 20:02:08'
        ]);
        
        ChatMessage::create([
            'chat_id'=>17,
            'by_customer'=>1,
            'message_content'=>'1727006528.png',
            'message_type'=>'image',
            'created_at'=>'2024-09-22 20:02:08'
        ]);
        
        ChatMessage::create([
            'chat_id'=>18,
            'by_customer'=>1,
            'message_content'=>'g',
            'message_type'=>'text',
            'created_at'=>'2024-09-22 20:05:30'
        ]);
        
        ChatMessage::create([
            'chat_id'=>18,
            'by_customer'=>1,
            'message_content'=>'1727006731.png',
            'message_type'=>'image',
            'created_at'=>'2024-09-22 20:05:31'
        ]);
    }
}

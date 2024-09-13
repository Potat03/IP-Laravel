<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Promotion;
use App\Models\PromotionItem;
use Carbon\Carbon;

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
            'price' => '100',
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
            'status' => 'active',
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
            'subtotal' => '8400',
            'delivery_fee' => '5',
            'total_discount' => '2220',
            'total' => '6185',
        ]);

        Promotion::create([
            'title'=>'promotion1',
            'description'=>'promotion_description',
            'discount'=>'10',
            'discount_amount'=> '990',
            'original_price'=>'1100',
            'type'=>'test',
            'limit'=>'10',
            'status' =>'active',
            'start_at' => Carbon::now(), 
            'end_at' => Carbon::now()->addDays(7), 
        ]);
        PromotionItem::create([
            'promotion_id'=>'1',
            'product_id'=>'1',
            'quantity'=>'1',
        ]);
        PromotionItem::create([
            'promotion_id'=>'1',
            'product_id'=>'2',
            'quantity'=>'1',
        ]);

        Promotion::create([
            'title'=>'promotion2',
            'description'=>'promotion_description',
            'discount'=>'50',
            'discount_amount'=> '1000',
            'original_price'=>'2000',
            'type'=>'test',
            'limit'=>'10',
            'status' =>'active',
            'start_at' => Carbon::now(), 
            'end_at' => Carbon::now()->addDays(7), 
        ]);
        PromotionItem::create([
            'promotion_id'=>'2',
            'product_id'=>'2',
            'quantity'=>'1',
        ]);
        PromotionItem::create([
            'promotion_id'=>'2',
            'product_id'=>'3',
            'quantity'=>'1',
        ]);
    
        
        CartItem::create([
            'customer_id' => '1',
            'product_id' => '1',
            'promotion_id' =>null,
            'quantity' => '2',
            'subtotal' => '200',
            'discount' => '0',
            'total' => '200', 
        ]);

        CartItem::create([
            'customer_id' => '1',
            'product_id' => '2',
            'promotion_id' => null,
            'quantity' => '2',
            'subtotal' => '2000',
            'discount' => '0',
            'total' => '2000', 
        ]);

        
        CartItem::create([
            'customer_id' => '1',
            'product_id' => null,
            'promotion_id' =>'1',
            'quantity' => '2',
            'subtotal' => '2200',
            'discount' => '220',
            'total' => '1980', 
        ]);

        CartItem::create([
            'customer_id' => '1',
            'product_id' => null,
            'promotion_id' => '2',
            'quantity' => '2',
            'subtotal' => '4000',
            'discount' => '2000',
            'total' => '2000', 
        ]);


        


    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderItem;
use App\Models\Order;
use App\Models\Product;
use App\Models\Promotion;


class OrderController extends Controller
{
    public function getOrderByCustomerID()
    {
        try {
            // Replace with authenticated user in production
            //$user = Auth::guard('customer')->user();
            //$customerID = $user->id;
            $customerID = 1;
    
            // Fetch orders based on customer ID
            $orders = Order::where('customer_id', $customerID)->get();
    
            if ($orders->isEmpty()) {
                Log::warning('No orders found for Customer ID: ' . $customerID);
            } else {
                // Attach order items to each order
                foreach ($orders as $order) {
                    $order->orderItems = OrderItem::where('order_id', $order->order_id)->get();
                    foreach($order->orderItems as $orderItem){
                        if($orderItem->product_id !=null){
                            $orderItem->product = Product::where('product_id', $orderItem->product_id)->first();
                        }else{
                            $orderItem->promotion = Promotion::where('promotion_id', $orderItem->promotion_id)->first();
                        }
                    }
                }
            }
    
            // Check if the request expects a JSON response (from AJAX or API)
            // if ($request->expectsJson()) {
            //     return response()->json($orders, 200);  // Return orders in JSON format
            // }
    
            // Otherwise, return the view (for standard browser requests)
            return view('tracking', ['orders' => $orders]);
        } catch (Exception $e) {
            Log::error('Fetching orders failed: ' . $e->getMessage());
            return response()->json(['error' => 'Fetching orders failed.'], 500);
        }
    }
    

    public function proceedToNext(Order $order)
    {
        try {
            $order->proceedToNext();
            return response()->json(['message' => 'Order state has been updated.']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}

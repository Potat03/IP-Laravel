<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
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
    
          
            return view('tracking', ['orders' => $orders]);
        } catch (Exception $e) {
            Log::error('Fetching orders failed: ' . $e->getMessage());
            return response()->json(['error' => 'Fetching orders failed.'], 500);
        }
    }
    
    
    // Design Pattern
    public function proceedToNext(Request $request, $id)
    {
        $order = Order::where('order_id',$id)->first();
        try {
            $order->proceedToNext();
            return response()->json(['success' => true,'message' => 'Order state has been updated.']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function rateOrder(Request $request, $id)
    {
        //Databse security
        $request->validate([
            'rating' => 'required|numeric',
        ]);
        $order = Order::where('order_id',$id)->first();
        $rating= $request->input('rating');

        try {
            $order->rateOrder($rating);
            return response()->json(['success' => true,'rating' => $rating,'message' => 'Order state has been updated.']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

   
    //Admin part
    public function getAllOrders()
    {
        try {
    
            $orders = Order::all();
    
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
            $filter = 'all';
            return view('admin.orders_management', ['orders' => $orders, 'filter'=>$filter]);
        } catch (Exception $e) {
            Log::error('Fetching orders failed: ' . $e->getMessage());
            return response()->json(['error' => 'Fetching orders failed.'], 500);
        }
    }

    public function getPrepareOrders()
    {
      
        try {
    
            $orders = Order::where('status', 'prepare')->get();
          
            if ($orders->isEmpty()) {
                $orders = null;
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
            return view('admin.orders_prepare', ['orders' => $orders]);
        } catch (Exception $e) {
            Log::error('Fetching orders failed: ' . $e->getMessage());
            return response()->json(['error' => 'Fetching orders failed.'], 500);
        }
    }


    public function getDeliveryOrders()
    {
      
        try {
    
            $orders = Order::where('status', 'delivery')->get();
    
            if ($orders->isEmpty()) {
                $orders = null;
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
            return view('admin.orders_delivery', ['orders' => $orders]);
        } catch (Exception $e) {
            Log::error('Fetching orders failed: ' . $e->getMessage());
            return response()->json(['error' => 'Fetching orders failed.'], 500);
        }
    }

    public function getDeliveredOrders()
    {
        try {
            $orders = Order::where('status', 'delivered')->get();
    
            if ($orders->isEmpty()) {
                $orders = null;
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
            return view('admin.orders_delivered', ['orders' => $orders]);
        } catch (Exception $e) {
            Log::error('Fetching orders failed: ' . $e->getMessage());
            return response()->json(['error' => 'Fetching orders failed.'], 500);
        }
    }
}

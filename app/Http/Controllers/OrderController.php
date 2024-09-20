<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\OrderItem;
use App\Models\Order;
use App\Models\Product;
use App\Models\Promotion;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use App\Models\PromotionItem;
use App\Models\Wearable;
use App\Models\Consumable;
use App\Models\Collectible;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use App\Models\APIKEY;


use function Pest\Laravel\json;

class OrderController extends Controller
{
    public function getOrderByCustomerID()
    {
        try {
              //comunication security     
       $user = Auth::guard('customer')->user();
       $customerID = $user->customer_id;
    
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
            return response()->json(['error' => 'Unable to retrieve orders at this time.'], 500);
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
            return response()->json(['error' => 'Unable to proceed to next status at this time.'], 500);
        }
    }

    public function receiveOrder(Request $request, $id)
    {
        
        $order = Order::where('order_id',$id)->first();

        try {
            $order->receiveOrder();
            return response()->json(['success' => true,'message' => 'Order state has been updated.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unable to receive orders at this time.'], 500);
        }
    }

   
    //Admin part
    public function getAllOrders()
    {
        try {
    
            $orders = Order::all();
    
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
            $filter = 'all';
            return view('admin.orders_management', ['orders' => $orders, 'filter'=>$filter]);
        } catch (Exception $e) {
            return response()->json(['error' => 'Unable to retrieve orders at this time.'], 500);
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
            return response()->json(['error' => 'Unable to retrieve orders at this time.'], 500);
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
            return response()->json(['error' => 'Unable to retrieve orders at this time.'], 500);
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
            return response()->json(['error' => 'Unable to retrieve orders at this time.'], 500);
        }
    }



    public function generateOrderStatusReport()
    {
        $orders = Order::select('order_id', 'customer_id', 'created_at', 'delivery_address', 'delivery_method', 'tracking_number', 'updated_at', 'received', 'status')
        ->orderBy('created_at', 'desc')
        ->get();

        foreach ($orders as $order) {
            $updatedAt = Carbon::parse($order->updated_at);
            $now = Carbon::now();
    
            // Calculate the difference in total hours
            $totalHours = $updatedAt->diffInHours($now);
    
            // Calculate the number of full days (24-hour blocks) and remaining hours
            $days = intdiv($totalHours, 24);  // Full days
            $hours = $totalHours % 24;        // Remaining hours
    
            // Format as "X days Y hours"
            $order->time_since_update = "{$days} days {$hours} hours";
        }
    
        
        $xmlContent = $this->generateXMLContent($orders);

        Storage::put('xml/order_status_report.xml', $xmlContent);

        // Load the XSLT stylesheet
        $xslt = new \DOMDocument();
        $xslt->load(storage_path('app/xslt/order_status_report.xslt'));

        // Load XML data
        $xml = new \DOMDocument();
        $xml->loadXML($xmlContent);

        $proc = new \XSLTProcessor();
        $proc->importStylesheet($xslt);

        $html = $proc->transformToXML($xml);

        return view('admin.order_status_report', ['html' => $html], ['orders' => $orders]);
    }

    private function generateXMLContent($orders)
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<orderStatusReport>';

        foreach ($orders as $order) {
            $xml .= '<order>';
            $xml .= '<orderID>' . $order->order_id . '</orderID>';
            $xml .= '<customerID>' . $order->customer_id . '</customerID>';
            $xml .= '<deliveryAddress>' . $order->delivery_address . '</deliveryAddress>';
            $xml .= '<deliveryMethod>' . $order->delivery_method . '</deliveryMethod>';
            $xml .= '<trackingNumber>' . $order->tracking_number . '</trackingNumber>';
            $xml .= '<received>' . ($order->received == 1 ? 'TRUE' : 'FALSE') . '</received>';
            $xml .= '<createdAt>' . $order->created_at . '</createdAt>';
            $xml .= '<updatedAt>' . $order->updated_at . '</updatedAt>';
            $xml .= '<timeSinceUpdate>' . $order->time_since_update . '</timeSinceUpdate>';
            $xml .= '<status>' . $order->status . '</status>';
            $xml .= '</order>';
        }

        $xml .= '</orderStatusReport>';
        return $xml;
    }

    
    public function getMonthlySales()
    {
        $api = APIKEY::where('api_key', $request->api_key)->first();

            if(!$api){
                return response()->json(['success' => false, 'message' => 'Invalid Request'], 400);
            }
        // Get monthly sales data, grouped by month, and count the number of orders per month
        $monthlySales = Order::select(
                DB::raw('YEAR(created_at) as year'), 
                DB::raw('MONTH(created_at) as month'), 
                DB::raw('COUNT(order_id) as total_orders'),
                DB::raw('SUM(subtotal)  as subtotal'), 
                DB::raw('SUM(total_discount)  as total_discount'), 
                DB::raw('SUM(total) - 5 as total_sales') 
                )
            ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

            
            return response()->json($monthlySales);
        }
    
}

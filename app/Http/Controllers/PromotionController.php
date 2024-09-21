<?php
//Author : Nicholas Yap Jia Wey
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\APIKEY;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use App\Models\Promotion;
use App\Models\PromotionItem;
use App\Models\Product;
use App\Models\Wearable;
use App\Models\Consumable;
use App\Models\Collectible;
use App\Models\OrderItem;
use App\Memento\PromotionCaretaker;
use Illuminate\Support\Facades\Auth;
use ConsoleTVs\Charts\Classes\Chartjs\Chart;
use Exception;

class PromotionController extends Controller
{
    public function getPromotion()
    {
        try {
            $promotion = Promotion::all();

            foreach ($promotion as $promo) {
                $promo->product_list = Promotion::find($promo->promotion_id)->product;
            }

            return response()->json(['success' => true, 'data' => $promotion], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }

    public function getPromotionById($id)
    {
        try {
            $promotion = Promotion::find($id);
            $promotion->product_list = Promotion::find($id)->product;

            return response()->json(['success' => true, 'data' => $promotion], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }

    public function createPromotion(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string',
                'description' => 'required|string',
                'discount' => 'required|numeric',
                'type' => 'required|string',
                'limit' => 'required|numeric',
                'start_date' => 'required|date',
                'end_date' => 'required|date',
                'status' => 'required|string'
            ]);

            $productList = json_decode($request->products);
            $originalPrice = 0;

            foreach ($productList as $product) {
                $originalPrice += Product::find($product->product_id)->price * $product->quantity;
            }

            $discountAmount = $originalPrice - ($originalPrice * $request->discount / 100);

            $newPromo = Promotion::create([
                'title' => $request->title,
                'description' => $request->description,
                'discount' => $request->discount,
                'discount_amount' => $discountAmount,
                'original_price' => $originalPrice,
                'type' => $request->type,
                'limit' => $request->limit,
                'start_at' => $request->start_date,
                'end_at' => $request->end_date,
                'status' => $request->status
            ]);

            foreach ($productList as $product) {
                PromotionItem::create([
                    'promotion_id' => $newPromo->promotion_id,
                    'product_id' => $product->product_id,
                    'quantity' => $product->quantity
                ]);
            }

            return response()->json(['success' => true], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }

    public function updatePromotion(Request $request, $id)
    {
        try {
            $promotion = Promotion::find($id);
            $promotionCaretaker = new PromotionCaretaker();
            $promotionCaretaker->addMemento($promotion->saveToMemento());

            $originalPrice = 0;
            $productList = json_decode($request->products);

            foreach ($productList as $product) {
                $originalPrice += Product::find($product->product_id)->price * $product->quantity;
            }

            $discountAmount = $originalPrice - ($originalPrice * $request->discount / 100);

            $promotion->title = $request->title;
            $promotion->description = $request->description;
            $promotion->discount = $request->discount;
            $promotion->discount_amount = $discountAmount;
            $promotion->original_price = $originalPrice;
            $promotion->type = $request->type;
            $promotion->limit = $request->limit;
            $promotion->start_at = $request->start_date;
            $promotion->end_at = $request->end_date;
            $promotion->status = $request->status;
            $promotion->save();

            $productList = json_decode($request->products);

            PromotionItem::where('promotion_id', $id)->delete();

            foreach ($productList as $product) {
                PromotionItem::create([
                    'promotion_id' => $id,
                    'product_id' => $product->product_id,
                    'quantity' => $product->quantity
                ]);
            }
            return response()->json(['success' => true, 'data' => $promotion], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }

    public function deletePromotion($id)
    {
        try {
            $promotion = Promotion::find($id);
            $promotionCaretaker = new PromotionCaretaker();
            $promotionCaretaker->addMemento($promotion->saveToMemento());

            $promotion->status = 'deleted';
            $promotion->save();
            return response()->json(['success' => true, 'data' => $promotion], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }

    public function togglePromotion($id)
    {
        try {
            $promotion = Promotion::find($id);
            if ($promotion->status == 'active') {
                $promotion->status = 'inactive';
            } else {
                $promotion->status = 'active';
            }
            $promotion->save();
            return response()->json(['success' => true, 'data' => $promotion], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }

    public function undoDeletePromotion($id)
    {
        try {
            $promotion = Promotion::find($id);
            //get the memento object
            $promotionCaretaker = new PromotionCaretaker();
            $promotionMemento = $promotionCaretaker->getMemento($id);
            $promotion->restoreFromMemento($promotionMemento);

            return response()->json(['success' => true, 'data' => $promotion], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }

    public function undoUpdatePromotion($index)
    {
        try {
            $promotionCaretaker = new PromotionCaretaker();
            $promotionMemento = $promotionCaretaker->getMemento($index);
            $promotion = Promotion::find($promotionMemento->getPromotion()['promotion_id']);
            $promotion->restoreFromMemento($promotionMemento);

            return response()->json(['success' => true, 'data' => $promotion], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }

    public function generatePromotionReport()
    {
        $revenueByPromotion = [];
    
        $promotions = Promotion::all();
    
        foreach ($promotions as $promotion) {
            $promotionOrders = OrderItem::where('promotion_id', $promotion->promotion_id)->get();
            $ordersWithoutPromotion = OrderItem::whereNull('promotion_id')->get();
    
            $totalRevenue = 0;
            $totalSold = 0;
            $totalOrderValueWithPromotion = 0;
            $totalOrderValueWithoutPromotion = 0;
            $orderCountWithPromotion = 0;
            $orderCountWithoutPromotion = 0;
    
            foreach ($promotionOrders as $order) {
                $totalRevenue += $order->total;
                $totalSold += $order->quantity;
                $totalOrderValueWithPromotion += $order->total;
                $orderCountWithPromotion++;
            }
    
            foreach ($ordersWithoutPromotion as $order) {
                $totalOrderValueWithoutPromotion += $order->total;
                $orderCountWithoutPromotion++;
            }
    
            $averageOrderValueWithPromotion = $orderCountWithPromotion > 0 ? $totalOrderValueWithPromotion / $orderCountWithPromotion : 0;
            $averageOrderValueWithoutPromotion = $orderCountWithoutPromotion > 0 ? $totalOrderValueWithoutPromotion / $orderCountWithoutPromotion : 0;
    
            $revenueByPromotion[$promotion->promotion_id] = [
                'title' => $promotion->title,
                'start_at' => $promotion->start_at,
                'end_at' => $promotion->end_at,
                'totalRevenue' => $totalRevenue,
                'productsSold' => $totalSold,
                'averageOrderValueWithPromotion' => $averageOrderValueWithPromotion,
                'averageOrderValueWithoutPromotion' => $averageOrderValueWithoutPromotion,
                'orders' => $promotionOrders,
            ];
        }
    
        $chartData = [];
        $allMonths = [];
    
        foreach ($revenueByPromotion as $promotionId => $data) {
            $months = [];
            $revenue = [];
    
            foreach ($data['orders'] as $order) {
                $orderMonth = $order->created_at->format('Y-m');
                if (!isset($revenue[$orderMonth])) {
                    $revenue[$orderMonth] = 0;
                }
                $revenue[$orderMonth] += $order->total;
                if (!in_array($orderMonth, $months)) {
                    $months[] = $orderMonth;
                }
            }
    
            $chartData[$data['title']] = [
                'months' => $months,
                'revenue' => array_values($revenue),
            ];
    
            $allMonths = array_unique(array_merge($allMonths, $months));
        }
    
        $chart = new Chart;
    
        $chart->options([
            'responsive' => true,
            'maintainAspectRatio' => false,
            'scales' => [
                'x' => [
                    'beginAtZero' => true,
                    'type' => 'category',
                    'labels' => $allMonths,
                ],
                'y' => [
                    'beginAtZero' => true,
                ],
            ],
        ]);
    
        foreach ($chartData as $title => $data) {
            $chart->labels($data['months']);
            $chart->dataset($title, 'line', $data['revenue']);
        }
    
        $xmlContent = $this->generateXMLContent($revenueByPromotion);
    
        Storage::put('xml/promotion_report.xml', $xmlContent);
    
        $xslt = new \DOMDocument();
        $xslt->load(storage_path('app/xslt/promotion_report.xslt'));
    
        $xml = new \DOMDocument();
        $xml->loadXML($xmlContent);
    
        $proc = new \XSLTProcessor();
        $proc->importStylesheet($xslt);
    
        $html = $proc->transformToXML($xml);
    
        return view('admin.promotion_report', ['html' => $html], compact('chart'));
    }

    protected function generateXMLContent($revenueByPromotion)
    {
        $xml = new \DOMDocument('1.0', 'UTF-8');
        $xml->formatOutput = true;
    
        $root = $xml->createElement('PromotionReports');
        $xml->appendChild($root);
    
        foreach ($revenueByPromotion as $promotionId => $data) {
            // Create promotion element
            $promotionElement = $xml->createElement('Promotion');
            $root->appendChild($promotionElement);
    
            // Add promotion details
            $promotionElement->appendChild($xml->createElement('ID', $promotionId));
            $promotionElement->appendChild($xml->createElement('Title', htmlspecialchars($data['title'])));
            $promotionElement->appendChild($xml->createElement('StartDate', $data['start_at']));
            $promotionElement->appendChild($xml->createElement('EndDate', $data['end_at']));
    
            // Add revenue and metrics
            $revenueElement = $xml->createElement('RevenueDetails');
            $promotionElement->appendChild($revenueElement);
    
            $totalRevenueElement = $xml->createElement('TotalRevenue', number_format($data['totalRevenue'], 2));
            $revenueElement->appendChild($totalRevenueElement);
    
            $averageOrderValueWithElement = $xml->createElement('AverageOrderValueWith', number_format($data['averageOrderValueWithPromotion'], 2));
            $revenueElement->appendChild($averageOrderValueWithElement);
    
            $averageOrderValueWithoutElement = $xml->createElement('AverageOrderValueWithout', number_format($data['averageOrderValueWithoutPromotion'], 2));
            $revenueElement->appendChild($averageOrderValueWithoutElement);
    
            $productsSoldElement = $xml->createElement('ProductsSold', $data['productsSold']);
            $promotionElement->appendChild($productsSoldElement);
    
            // Add monthly revenue details
            $monthlyRevenueElement = $xml->createElement('MonthlyRevenue');
            $promotionElement->appendChild($monthlyRevenueElement);
    
            $monthlyRevenue = [];
    
            foreach ($data['orders'] as $order) {
                $orderMonth = $order->created_at->format('Y-m'); // Format month as YYYY-MM
                if (!isset($monthlyRevenue[$orderMonth])) {
                    $monthlyRevenue[$orderMonth] = 0;
                }
                $monthlyRevenue[$orderMonth] += $order->total;
            }
    
            foreach ($monthlyRevenue as $month => $revenue) {
                $monthElement = $xml->createElement('Month');
                $monthlyRevenueElement->appendChild($monthElement);
    
                $monthElement->appendChild($xml->createElement('MonthName', $month));
                $monthElement->appendChild($xml->createElement('Revenue', number_format($revenue, 2)));
            }
        }
    
        return $xml->saveXML();
    }

    public function downloadXMLReport()
    {
        return Storage::download('xml/promotion_report.xml');
    }

    public function showPromotionList($ids)
    {
        try {
            $ids = explode(',', $ids);
            $promotion = Promotion::whereIn('promotion_id', $ids)->get();
            return view('promotion', ['promotion' => $promotion]);
        } catch (Exception $e) {
            return view('errors.404');
        }
    }

    public function customerList()
    {
        try {
            $promotions = Promotion::where('status', 'active')->paginate(12);
            foreach ($promotions as $promotion) {
                $promotion->product_list = Promotion::find($promotion->promotion_id)->product;

                if ($promotion->created_at->diffInDays(now()) < 3) {
                    $promotion->is_new = true;
                } else {
                    $promotion->is_new = false;
                }

                foreach ($promotion->product_list as $product) {
                    $product->quantity = PromotionItem::where('product_id', $product->product_id)->where('promotion_id', $promotion->promotion_id)->first()->quantity;
                }
            }

            $categories = Category::all();

            return view('promotion', ['promotions' => $promotions, 'categories' => $categories]);
        } catch (Exception $e) {
            return view('errors.404');
        }
    }

    public function viewDetails($id)
    {
        try {
            $promotion = Promotion::find($id);
            $promotion->product_list = Promotion::find($id)->product;
            if ($promotion->status == 'deleted' || $promotion->status == 'inactive') {
                return view('errors.404');
            }


            foreach ($promotion->product_list as $product) {
                $product->quantity = PromotionItem::where('product_id', $product->product_id)->where('promotion_id', $id)->first()->quantity;
                switch ($product->getProductType()) {
                    case 'Wearable':
                        $product->type = 'wearable';
                        $product->wearable = Wearable::find($product->product_id);
                        break;
                    case 'Consumable':
                        $product->type = 'consumable';
                        $product->consumable = Consumable::find($product->product_id);
                        break;
                    case 'Collectible':
                        $product->type = 'collectible';
                        $product->collectible = Collectible::find($product->product_id);
                        break;
                    default:
                        $product->type = 'wearable';
                        $product->wearable = Wearable::find($product->product_id);
                }
            }

            $promotion->bought_count = 0;

            return view('promotionDetails', ['promotion' => $promotion]);
        } catch (Exception $e) {
            return view('errors.404');
        }
    }

    public function adminList()
    {
        try {

            if (Auth::guard('admin')->check()) {
                $promotions = Promotion::whereNot('status', 'deleted')->paginate(12);
                foreach ($promotions as $promotion) {
                    $promotion->product_list = Promotion::find($promotion->promotion_id)->product;
                }
                return view('admin.promotion', ['promotions' => $promotions]);
            } else {
                return view('errors.404');
            }
        } catch (Exception $e) {
            return view('errors.404');
        }
    }

    public function addPromotion()
    {
        try {
            if (Auth::guard('admin')->check()) {
                if (Auth::guard('admin')->user()->role != 'admin' && Auth::guard('admin')->user()->role != 'manager') {
                    return view('errors.404');
                }
            } else {
                return view('errors.404');
            }


            $products = Product::all();
            return view('admin.promotion_add', ['products' => $products]);
        } catch (Exception $e) {
            return view('errors.404');
        }
    }

    public function editPromotion($id)
    {
        try {
            if (Auth::guard('admin')->check()) {
                if (Auth::guard('admin')->user()->role != 'admin' && Auth::guard('admin')->user()->role != 'manager') {
                    return view('errors.404');
                }
            } else {
                return view('errors.404');
            }

            $promotion = Promotion::find($id);
            $promotion->product_list = Promotion::find($id)->product;
            $products = Product::all();

            foreach ($promotion->product_list as $product) {
                $product->quantity = PromotionItem::where('product_id', $product->product_id)->where('promotion_id', $id)->first()->quantity;
            }
            return view('admin.promotion_edit', ['promotion' => $promotion, 'products' => $products]);
        } catch (Exception $e) {
            return view('errors.404');
        }
    }

    public function restorePromotion()
    {
        try {
            if (Auth::guard('admin')->check()) {
                if (Auth::guard('admin')->user()->role != 'admin' && Auth::guard('admin')->user()->role != 'manager') {
                    return view('errors.404');
                }
            } else {
                return view('errors.404');
            }

            $promotions = Promotion::where('status', 'deleted')->get();
            foreach ($promotions as $promotion) {
                $promotion->product_list = Promotion::find($promotion->promotion_id)->product;
            }
            return view('admin.promotion_restore', ['promotions' => $promotions]);
        } catch (Exception $e) {
            return view('errors.404');
        }
    }

    public function undoListPromotion()
    {
        try {
            if (Auth::guard('admin')->check()) {
                if (Auth::guard('admin')->user()->role != 'admin' && Auth::guard('admin')->user()->role != 'manager') {
                    return view('errors.404');
                }
            } else {
                return view('errors.404');
            }

            $promotionCaretaker = new PromotionCaretaker();
            $mementoList = $promotionCaretaker->getMementoList();

            // Extract promotions from mementos
            $promotions = array_map(function ($memento) {
                return $memento->getPromotion();
            }, $mementoList);

            //convert to object
            $promotions = json_decode(json_encode($promotions));

            return view('admin.promotion_revert', ['promotions' => $promotions]);
        } catch (Exception $e) {
            return view('errors.404');
        }
    }

    public function promotionPublic(Request $request)
    {
        try {
            $api = APIKEY::where('api_key', $request->api_key)->first();

            if(!$api){
                return response()->json(['success' => false, 'message' => 'Invalid Request'], 400);
            }

            $promotions = Promotion::where('status', 'active')->get();
            foreach ($promotions as $promotion) {
                $promotion->product_list = Promotion::find($promotion->promotion_id)->product;
            }
            return response()->json(['success' => true, 'data' => $promotions], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }
}

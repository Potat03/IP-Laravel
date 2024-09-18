<?php

namespace App\Http\Controllers;

use App\Models\Category;
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

            Cache::put('promotion_' . $id, $promotion, 86400);

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
            $promotion->status = 'inactive';
            $promotion->save();
            return response()->json(['success' => true, 'data' => $promotion], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }

    public function generatePromotionReport()
    {
        $promotions = Promotion::all();

        //calculate total revenue
        foreach ($promotions as $promotion) {
            $promotion->total_revenue = 0;
            $promotion->products_sold = 0;
            $promotion->average_order_value_with = 0;
            $promotion->average_order_value_without = 0;
            $promotion->orders = OrderItem::where('promotion_id', $promotion->promotion_id)->get();
            $promotion->items = PromotionItem::where('promotion_id', $promotion->promotion_id)->get();

            if ($promotion->orders) {
                foreach ($promotion->orders as $order) {
                    $promotion->total_revenue += $order->total;
                    $promotion->products_sold += count($promotion->items);
                }

                foreach ($promotion->items as $item) {
                    $orders = OrderItem::where('product_id', $item->product_id)->get();
                    foreach ($orders as $order) {
                        $promotion->total_revenue_without += $order->total;
                        $promotion->products_sold_without += count($orders);
                    }
                }
                
                if ($promotion->products_sold > 0) {
                    $promotion->average_order_value_with = $promotion->total_revenue / $promotion->products_sold;
                }

                if ($promotion->products_sold_without > 0) {
                    $promotion->average_order_value_without = $promotion->total_revenue_without / $promotion->products_sold_without;
                }
            }
        }

        $xmlContent = $this->generateXMLContent($promotions);

        Storage::put('xml/promotion_report.xml', $xmlContent);

        // Load the XSLT stylesheet
        $xslt = new \DOMDocument();
        $xslt->load(storage_path('app/xslt/promotion_report.xslt'));

        // Load XML data
        $xml = new \DOMDocument();
        $xml->loadXML($xmlContent);

        $proc = new \XSLTProcessor();
        $proc->importStylesheet($xslt);

        $html = $proc->transformToXML($xml);

        return view('admin.promotion_report', ['html' => $html], ['promotions' => $promotions]);
    }

    private function generateXMLContent($promotions)
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<promotionPerformanceReport>';

        foreach ($promotions as $promotion) {
            $xml .= '<promotion>';
            $xml .= '<id>' . $promotion->promotion_id . '</id>';
            $xml .= '<title>' . $promotion->title . '</title>';
            $xml .= '<totalRevenue>' . $promotion->total_revenue . '</totalRevenue>';
            $xml .= '<productsSold>' . $promotion->products_sold . '</productsSold>';
            $xml .= '<averageOrderValueWithPromotion>' . $promotion->average_order_value_with . '</averageOrderValueWithPromotion>';
            $xml .= '<averageOrderValueWithoutPromotion>' . $promotion->average_order_value_without . '</averageOrderValueWithoutPromotion>';
            $xml .= '</promotion>';
        }

        $xml .= '</promotionPerformanceReport>';
        return $xml;
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

            // if(auth()->check()){
            //     $promotion->bought_count = Promotion::find($id)->order->where('customer_id', auth()->user()->customer_id)->count();
            // }else{
            //     $promotion->bought_count = $promotion->limit;
            // }

            return view('promotionDetails', ['promotion' => $promotion]);
        } catch (Exception $e) {
            return view('errors.404');
        }
    }

    public function adminList()
    {
        try {
            $promotions = Promotion::whereNot('status', 'deleted')->paginate(12);
            foreach ($promotions as $promotion) {
                $promotion->product_list = Promotion::find($promotion->promotion_id)->product;
            }
            return view('admin.promotion', ['promotions' => $promotions]);
        } catch (Exception $e) {
            return view('errors.404');
        }
    }

    public function addPromotion()
    {
        $products = Product::all();
        return view('admin.promotion_add', ['products' => $products]);
    }

    public function editPromotion($id)
    {
        try {
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
            $promotions = Promotion::where('status', 'deleted')->get();
            foreach ($promotions as $promotion) {
                $promotion->product_list = Promotion::find($promotion->promotion_id)->product;
            }
            return view('admin.promotion_restore', ['promotions' => $promotions]);
        } catch (Exception $e) {
            return view('errors.404');
        }
    }
}

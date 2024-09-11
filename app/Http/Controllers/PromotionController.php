<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\Promotion;
use App\Models\PromotionItem;
use App\Models\Product;
use Exception;

class PromotionController extends Controller
{
    //api method
    public function getPromotion(){
        try{
            $promotion = Promotion::all();

            foreach($promotion as $promo){
                $promo->product_list = Promotion::find($promo->promotion_id)->product;
            }
            
            return response()->json(['success' => true, 'data' => $promotion], 200);
        }
        catch(Exception $e){
            return response()->json(['success' => false, 'message' => '$e->getMessage()'], 400);
        }
    }    

    public function getPromotionById($id){
        try{
            $promotion = Promotion::find($id);
            $promotion->product_list = Promotion::find($id)->product;
            return response()->json(['success' => true, 'data' => $promotion], 200);
        }
        catch(Exception $e){
            return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }

    public function createPromotion(Request $request){
        try{
            //validate request
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

            //json to array
            $productList = json_decode($request->products);
            $originalPrice = 0;

            //get original price
            foreach($productList as $product){
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

            foreach($productList as $product){
                PromotionItem::create([
                    'promotion_id' => $newPromo->promotion_id,
                    'product_id' => $product->product_id,
                    'quantity' => $product->quantity
                ]);
            }

            return response()->json(['success' => true], 200);
        }
        catch(Exception $e){
            return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }

    public function updatePromotion(Request $request, $id){
        try{
            $promotion = Promotion::find($id);

            //store old data in cache for 1 day
            Cache::put('promotion_'.$id, $promotion, 86400);

            $originalPrice = 0;
            $productList = json_decode($request->products);
            
            //get original price
            foreach($productList as $product){
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

            //product list
            $productList = json_decode($request->products);

            //delete old product list
            PromotionItem::where('promotion_id', $id)->delete();

            //add new product list
            foreach($productList as $product){
                PromotionItem::create([
                    'promotion_id' => $id,
                    'product_id' => $product->product_id,
                    'quantity' => $product->quantity
                ]);
            }
            return response()->json(['success' => true, 'data' => $promotion], 200);
        }
        catch(Exception $e){
            return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }

    public function deletePromotion($id){
        try{
            //status = deleted
            $promotion = Promotion::find($id);
            $promotion->status = 'deleted';
            $promotion->save();
            return response()->json(['success' => true, 'data' => $promotion], 200);

        }
        catch(Exception $e){
            return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }

    public function togglePromotion($id){
        try{
            $promotion = Promotion::find($id);
            if($promotion->status == 'active'){
                $promotion->status = 'inactive';
            }else{
                $promotion->status = 'active';
            }
            $promotion->save();
            return response()->json(['success' => true, 'data' => $promotion], 200);
        }
        catch(Exception $e){
            return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }

    public function undoUpdatePromotion($id){
        try{
            $promotion = Promotion::find($id);
            $promotion->restoreCache();
            return response()->json(['success' => true, 'data' => $promotion], 200);
        }
        catch(Exception $e){
            return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }

    public function undoDeletePromotion($id){
        try{
            $promotion = Promotion::find($id);
            $promotion->status = 'active';
            $promotion->save();
            return response()->json(['success' => true, 'data' => $promotion], 200);
        }
        catch(Exception $e){
            return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }

    public function showPromotionList($ids){
        try{
            $ids = explode(',', $ids);
            $promotion = Promotion::whereIn('promotion_id', $ids)->get();
            return view('promotion', ['promotion' => $promotion]);
        }
        catch(Exception $e){
            return view('errors.404');
        }
    }

    //admin side
    
    public function adminList(){
        try{
            $promotions = Promotion::all();
            foreach($promotions as $promotion){
                $promotion->product_list = Promotion::find($promotion->promotion_id)->product;
            }
            return view('admin.promotion', ['promotions' => $promotions]);
        }
        catch(Exception $e){
            return view('errors.404');
        }
    }

    public function addPromotion(){
        $products = Product::all();
        return view('admin.promotion_add', ['products' => $products]);
    }

    public function editPromotion($id){
        try{
            $promotion = Promotion::find($id);
            $promotion->product_list = Promotion::find($id)->product;
            $products = Product::all();
            return view('admin.promotion_edit', ['promotion' => $promotion, 'products' => $products]);
        }
        catch(Exception $e){
            return view('errors.404');
        }
    }
}


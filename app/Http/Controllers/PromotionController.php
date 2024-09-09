<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Interface\PromotionInterface;
use App\Models\Product;
use App\Models\Promotion;
use App\Models\PromotionItem;
use Exception;

class PromotionController extends Controller
{
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


            $newPromo = Promotion::create([
                'title' => $request->title,
                'description' => $request->description,
                'discount' => $request->discount,
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
            $promotion->storeCache();

            $promotion->title = $request->title;
            $promotion->description = $request->description;
            $promotion->discount = $request->discount;
            $promotion->save();
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
}


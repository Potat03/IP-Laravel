<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Interface\PromotionInterface;
use App\Models\Promotion;
use Exception;

class PromotionController extends Controller implements PromotionInterface
{
    public function getPromotion(){
        try{
            $promotion = Promotion::all();
            return response()->json(['success' => true, 'data' => $promotion], 200);
        }
        catch(Exception $e){
            return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
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
            $promotion = new Promotion();
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

    public function updatePromotion(Request $request, $id){
        try{
            $promotion = Promotion::find($id);
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
            $promotion = Promotion::find($id);
            $promotion->delete();
            return response()->json(['success' => true, 'data' => $promotion], 200);
        }
        catch(Exception $e){
            return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }

    public function undoDeletePromotion($id){
        try{
            $promotion = Promotion::withTrashed()->find($id);
            $promotion->restore();
            return response()->json(['success' => true, 'data' => $promotion], 200);
        }
        catch(Exception $e){
            return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }
}


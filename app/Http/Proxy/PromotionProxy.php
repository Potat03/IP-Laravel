<?php

namespace App\Http\Proxy;

use Illuminate\Http\Request;
use App\Http\Controllers\Interface\PromotionInterface;
use App\Http\Controllers\PromotionController;

class PromotionProxy extends PromotionController implements PromotionInterface
{
    public function getPromotion(){
        return $this->getPromotion();
    }    

    public function getPromotionById($id){
        return $this->getPromotionById($id);
    }

    public function createPromotion(Request $request){
        //check if user is admin
        if($_SESSION['role'] != 'admin' || $_SESSION['role'] != 'manager'){
            return response()->json(['success' => false, 'message' => 'You are not authorized to create promotion'], 400);
        }
        return $this->createPromotion($request);
    }

    public function updatePromotion(Request $request, $id){
        //check if user is admin
        if($_SESSION['role'] != 'admin' || $_SESSION['role'] != 'manager'){
            return response()->json(['success' => false, 'message' => 'You are not authorized to update promotion'], 400);
        }
        return $this->updatePromotion($request, $id);
    }

    public function deletePromotion($id){
        //check if user is admin
        if($_SESSION['role'] != 'admin' || $_SESSION['role'] != 'manager'){
            return response()->json(['success' => false, 'message' => 'You are not authorized to delete promotion'], 400);
        }
        return $this->deletePromotion($id);
    }
}


<?php

namespace App\Http\Proxy;

use Illuminate\Http\Request;
use App\Http\Controllers\Interface\PromotionInterface;
use App\Http\Controllers\PromotionController;

class PromotionProxy extends PromotionController implements PromotionInterface
{
    public function getPromotion(){
        return parent::getPromotion();
    }    

    public function getPromotionById($id){
        return parent::getPromotionById($id);
    }

    public function createPromotion(Request $request){
        //start session
        if(!isset($_SESSION)){
            session_start();
        }
        //check if role is set
        // if(!isset($_SESSION['role'])){
        //     return response()->json(['success' => false, 'message' => 'You are not authorized to create promotion'], 400);
        // }else{
        //     //check if user is admin
        //     if($_SESSION['role'] != 'admin' || $_SESSION['role'] != 'manager'){
        //         return response()->json(['success' => false, 'message' => 'You are not authorized to create promotion'], 400);
        //     }
        return parent::createPromotion($request);
        // }
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


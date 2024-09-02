<?php

namespace App\Http\Controllers\Interface;

use Illuminate\Http\Request;

interface PromotionInterface
{
    public function getPromotion();
    public function getPromotionById($id);
    public function createPromotion(Request $request);
    public function updatePromotion(Request $request, $id);
    public function deletePromotion($id);
}
<?php
//Author : Nicholas Yap Jia Wey
namespace App\Memento;

class PromotionMemento
{
    protected $state;

    public function __construct($promotion_id, $title, $description, $discount, $discount_amount, $original_price, $type, $limit, $status, $start_at, $end_at, $product_list)
    {
        $this->state = compact('promotion_id', 'title', 'description', 'discount', 'discount_amount', 'original_price', 'type', 'limit', 'status', 'start_at', 'end_at', 'product_list');
    }

    public function getPromotion()
    {
        return $this->state;
    }
}
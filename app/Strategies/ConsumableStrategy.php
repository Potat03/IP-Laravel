<?php

namespace App\Strategies;

use App\Models\Consumable;
use App\Strategies\SpecificProductStrategyInterface;

class ConsumableStrategy implements SpecificProductStrategyInterface
{
    private $product;

    public function __construct(Consumable $product)
    {
        $this->product = $product;
    }

    public function setSpecificAttributes(array $attributes)
    {
        if (isset($attributes['expire_date'])) {
            $this->product->expire_date = $attributes['expire_date'];
        }
        if (isset($attributes['portion'])) {
            $this->product->portion = $attributes['portion'];
        }
        if (isset($attributes['is_halal'])) {
            $this->product->is_halal = $attributes['is_halal'];
        }
        if (isset($attributes['product_id'])) {
            $this->product->product_id = $attributes['product_id'];
        }
    }

    public function getProduct()
    {
        return $this->product;
    }
}
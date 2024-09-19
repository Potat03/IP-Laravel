<?php
/**
 *
 * Author: Lim Weng Ni
 * Date: 20/09/2024
 */

namespace App\Strategies;

use App\Models\Wearable;
use App\Strategies\ProductStrategyInterface;

class WearableStrategy implements SpecificProductStrategyInterface
{
    private $product;

    public function __construct(Wearable $product)
    {
        $this->product = $product;
    }

    public function setSpecificAttributes(array $attributes)
    {
        if (isset($attributes['size'])) {
            $this->product->size = $attributes['size'];
        }
        if (isset($attributes['color'])) {
            $this->product->color = $attributes['color'];
        }
        if (isset($attributes['user_group'])) {
            $this->product->user_group = $attributes['user_group'];
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
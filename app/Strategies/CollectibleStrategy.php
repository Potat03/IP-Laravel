<?php
/**
 *
 * Author: Lim Weng Ni
 * Date: 20/09/2024
 */

namespace App\Strategies;

use App\Models\Collectible;

use App\Strategies\SpecificProductStrategyInterface;

class CollectibleStrategy implements SpecificProductStrategyInterface
{
    private $product;

    public function __construct(Collectible $product)
    {
        $this->product = $product;
    }

    public function setSpecificAttributes(array $attributes)
    {
        if (isset($attributes['supplier'])) {
            $this->product->supplier = $attributes['supplier'];
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
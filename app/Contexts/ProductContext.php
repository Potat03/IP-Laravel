<?php

namespace App\Contexts;

use App\Strategies\SpecificProductStrategyInterface;
use App\Models\Product;

class ProductContext
{
    private $specificStrategy;

    public function __construct(SpecificProductStrategyInterface $specificStrategy)
    {
        $this->specificStrategy = $specificStrategy;
    }

    public function applyStrategies(
        array $specificAttributes
    )
    {
        // Save specific attributes based on product type
        $specificProduct = $this->specificStrategy->getProduct();
        $this->specificStrategy->setSpecificAttributes($specificAttributes);
        $specificProduct->save();

        // Save the product
        $specificProduct->save();
    }
}

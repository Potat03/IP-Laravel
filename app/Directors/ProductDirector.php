<?php

namespace App\Directors;

use App\Builders\ProductBuilderInterface;

class ProductDirector
{
    private $builder;

    public function __construct(ProductBuilderInterface $builder)
    {
        $this->builder = $builder;
    }

    public function construct(array $productData, array $specificAttributes)
    {
        $this->builder->setProductName($productData['name']);
        $this->builder->setProductDescription($productData['description']);
        $this->builder->setProductPrice($productData['price']);
        $this->builder->setProductStock($productData['stock']);
        $this->builder->setSpecificAttributes($specificAttributes);

        return $this->builder->build();
    }
}

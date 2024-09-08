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
        $this->builder->setName($productData['name']);
        $this->builder->setDescription($productData['description']);
        $this->builder->setPrice($productData['price']);
        $this->builder->setStock($productData['stock']);
        $this->builder->setStatus($productData['status']);

        foreach($productData as $attribute => $value){
            if (method_exists($this->builder, "set" . ucfirst($attribute))) {
                $this->builder->{"set" . ucfirst($attribute)}($value);
            }
        }

        return $this->builder->build();
    }
}

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

    public function buildBasicProduct($name, $description, $price, $stock, $status, $created_at)
    {
        return $this->builder
            ->setName($name)
            ->setDescription($description)
            ->setPrice($price)
            ->setStock($stock)
            ->setStatus($status)
            ->setCreatedAt($created_at)
            ->build();
    }

    public function buildWearable(array $attributes, $productId)
    {
        return $this->builder
            ->setName("")
            ->setDescription("")
            ->setPrice(0)
            ->setStock(0)
            ->setStatus("")
            ->setSize($attributes['size'])
            ->setColor($attributes['color'])
            ->setUserGroup($attributes['user_group'])
            ->setProductId($productId)
            ->build();
    }

    public function buildCollectible(array $attributes, $productId)
    {
        return $this->builder
            ->setName("")
            ->setDescription("")
            ->setPrice(0)
            ->setStock(0)
            ->setStatus("")
            ->setSupplier($attributes['supplier'])
            ->setProductId($productId)
            ->build();
    }

    public function buildConsumable(array $attributes, $productId)
    {
        return $this->builder
            ->setName("")
            ->setDescription("")
            ->setPrice(0)
            ->setStock(0)
            ->setStatus("")
            ->setExpireDate($attributes['expire_date'] ?? null)
            ->setPortion($attributes['portion'] ?? "")
            ->setIsHalal($attributes['is_halal'] ?? false)
            ->setProductId($productId)
            ->build();
    }
}

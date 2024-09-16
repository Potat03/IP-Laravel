<?php

namespace App\Builders;

use App\Models\Product;

class ProductBuilder implements ProductBuilderInterface
{
    protected $product;

    public function __construct()
    {
        $this->product = new Product();
    }

    public function setName($name)
    {
        $this->product->name = $name;
        return $this;
    }

    public function setDescription($description)
    {
        $this->product->description = $description;
        return $this;
    }

    public function setPrice($price)
    {
        $this->product->price = $price;
        return $this;
    }

    public function setStock($stock)
    {
        $this->product->stock = $stock;
        return $this;
    }

    public function setStatus($status)
    {
        $this->product->status = $status;
        return $this;
    }

    public function setCreatedAt($created_at)
    {
        $this->product->created_at = $created_at;
        return $this;
    }

    public function build()
    {
        $this->product->save();
        return $this->product;
    }
}

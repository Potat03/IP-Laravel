<?php

namespace App\Builders;

use App\Models\Collectible;

class CollectibleBuilder implements ProductBuilderInterface
{
    private $collectible;

    public function __construct()
    {
        $this->collectible = new Collectible();
    }

    public function setName($name)
    {
        $this->collectible->name = $name;
        return $this;
    }

    public function setDescription($description)
    {
        $this->collectible->description = $description;
        return $this;
    }

    public function setPrice($price)
    {
        $this->collectible->price = $price;
        return $this;
    }

    public function setStock($stock)
    {
        $this->collectible->stock = $stock;
        return $this;
    }

    public function setStatus($status)
    {
        $this->collectible->status = $status;
        return $this;
    }

    public function setSupplier($supplier)
    {
        $this->collectible->supplier = $supplier;
        return $this;
    }

    public function setProductId($id)
    {
        $this->collectible->product_id = $id;
        return $this;
    }

    // Return the built product
    public function build()
    {
        $collectible = new Collectible();
        $collectible->product_id = $this->collectible->product_id;
        $collectible->supplier = $this->collectible->supplier;

        return $collectible;
    }
}

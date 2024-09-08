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

    // Return the built product
    public function build():Collectible
    {
        return $this->collectible;
    }
}

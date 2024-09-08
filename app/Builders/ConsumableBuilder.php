<?php

namespace App\Builders;

use App\Models\Consumable;

class ConsumableBuilder implements ProductBuilderInterface
{
    private $consumable;

    public function __construct()
    {
        $this->consumable = new Consumable(); 
    }

    public function setName($name)
    {
        $this->consumable->name = $name;
        return $this;
    }

    public function setDescription($description)
    {
        $this->consumable->description = $description;
        return $this;
    }

    public function setPrice($price)
    {
        $this->consumable->price = $price;
        return $this;
    }

    public function setStock($stock)
    {
        $this->consumable->stock = $stock;
        return $this;
    }

    public function setStatus($status)
    {
        $this->consumable->status = $status;
        return $this;
    }

    public function setExpireDate($expireDate)
    {
        $this->consumable->expire_date = $expireDate;
        return $this;
    }

    public function setPortion($portion)
    {
        $this->consumable->portion = $portion;
        return $this;
    }

    public function setIsHalal($isHalal)
    {
        $this->consumable->is_halal = $isHalal;
        return $this;
    }

    // Return the built product
    public function build():Consumable
    {
        return $this->consumable;
    }
}

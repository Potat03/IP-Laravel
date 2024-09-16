<?php

namespace App\Builders;

use App\Models\Wearable;

class WearableBuilder implements ProductBuilderInterface
{
    private $wearable;

    public function __construct()
    {
        $this->wearable = new Wearable(); 
    }

    public function setName($name)
    {
        $this->wearable->name = $name;
        return $this;
    }

    public function setDescription($description)
    {
        $this->wearable->description = $description;
        return $this;
    }

    public function setPrice($price)
    {
        $this->wearable->price = $price;
        return $this;
    }

    public function setStock($stock)
    {
        $this->wearable->stock = $stock;
        return $this;
    }

    public function setStatus($status)
    {
        $this->wearable->status = $status;
        return $this;
    }

    // Wearable-specific methods
    public function setSize($size)
    {
        $this->wearable->size = $size;
        return $this;
    }

    public function setColor($color)
    {
        $this->wearable->color = $color;
        return $this;
    }

    public function setUserGroup($userGroup)
    {
        $this->wearable->user_group = $userGroup;
        return $this;
    }

    // Return the built product
    public function build():Wearable
    {
        return $this->wearable;
    }
}

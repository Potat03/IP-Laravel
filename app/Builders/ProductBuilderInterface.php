<?php

namespace App\Builders;

interface ProductBuilderInterface
{
    public function setName($name);
    public function setDescription($description);
    public function setPrice($price);
    public function setStock($stock);
    public function setStatus($status);
    public function build();
}

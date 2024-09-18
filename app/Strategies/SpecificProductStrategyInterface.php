<?php

namespace App\Strategies;

interface SpecificProductStrategyInterface
{
    public function setSpecificAttributes(array $attributes);

    public function getProduct(); 
}

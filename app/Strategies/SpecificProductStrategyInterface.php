<?php
/**
 *
 * Author: Lim Weng Ni
 * Date: 20/09/2024
 */

namespace App\Strategies;

interface SpecificProductStrategyInterface
{
    public function setSpecificAttributes(array $attributes);

    public function getProduct(); 
}

<?php
// Author: Loh Thiam Wei
namespace App\Messages;

interface MessageInterface
{
    public function getContent(): array;
}
<?php

namespace App\Messages;

interface MessageInterface
{
    public function getContent(): array;
}
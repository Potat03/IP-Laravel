<?php

namespace App\Models;

interface UserInterface
{
    public function getId();
    public function getRole();
    public function getStatus();
}
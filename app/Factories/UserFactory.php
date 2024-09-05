<?php

namespace App\Factories;

use App\Models\Admin;
use App\Models\Customer;
use App\Models\UserInterface;

class UserFactory
{
    public static function create(UserInterface $user): UserInterface
    {
        return $user;
    }
}

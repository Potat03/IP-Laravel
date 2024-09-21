<?php
// Author: Loh Thiam Wei
namespace App\Factories;

use App\Models\UserInterface;

class UserFactory
{
    public static function create(UserInterface $user): UserInterface
    {
        return $user;
    }
}

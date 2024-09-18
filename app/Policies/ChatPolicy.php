<?php

namespace App\Policies;

use App\Models\Chat;
use App\Models\UserInterface;
use Illuminate\Auth\Access\HandlesAuthorization;

class ChatPolicy
{
    use HandlesAuthorization;



    public function viewAny(UserInterface $user)
    {
        return $user->getRole() === 'customer' || $user->getRole() === 'manager' || $user->getRole() === 'customer_service';
    }

    public function viewChat(UserInterface $user, Chat $chat)
    {
        return ($user->getID() === $chat->admin_id && $user->getRole() === 'customer_service') || ($user->getID() === $chat->customer_id && $user->getRole() === 'customer') && ($chat->status === 'pending' || $chat->status === 'active');
    }
 
    public function sendMessages(UserInterface $user, Chat $chat)
    {
        return ($user->getID() === $chat->admin_id || $user->getID() === $chat->customer_id) && $chat->status === 'active';
    }

    public function end(UserInterface $user, Chat $chat)
    {
        return ($user->getID() === $chat->admin_id || $user->getID() === $chat->customer_id) && $chat->status === 'active';
    }

    public function getMessages(UserInterface $user, Chat $chat)
    {
        return $user->getID() === $chat->admin_id || $user->getID() === $chat->customer_id;
    }

    private function isCustomerSupport(UserInterface $user, Chat $chat)
    {
        return $user->getID() === $chat->admin_id;
    }

    private function isCustomer(UserInterface $user, Chat $chat)
    {
        return $user->getID() === $chat->customer_id && $user->getRole() === 'customer';
    }

    private function isManager(UserInterface $user, Chat $chat)
    {
        return $user->getID() === $chat->customer_id && $user->getRole() === 'manager';
    }

    private function isCustomerService(UserInterface $user, Chat $chat)
    {
        return $user->getID() === $chat->customer_id && $user->getRole() === 'customer_service';
    }

    

}

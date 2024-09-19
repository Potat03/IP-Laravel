<?php

namespace App\Policies;

use App\Models\Chat;
use App\Models\UserInterface;
use Illuminate\Auth\Access\HandlesAuthorization;

class ChatPolicy
{
    use HandlesAuthorization;

    public function viewChat(UserInterface $user, Chat $chat)
    {
        // If account is inactive, no access
        if (!$this->checkStatus($user)) {
            return false;
        }

        //Manager can view all chats no matter the status
        if ($user->getRole() === 'manager') {
            return true;
        }
        // Customer can only view thier own chat
        else if ($user->getRole() === 'customer' && $user->getID() === $chat->customer_id) {
            return true;
        }
        // IF chat is active, only customer_service handling it can view
        else if ($user->getRole() === 'customer_service') {
            if ($chat->status === 'active') {
                if ($chat->admin_id === $user->getID()) {
                    return true;
                }
            } else {
                return true;
            }
        }
        return false;
    }

    public function getChatList(UserInterface $user)
    {
        // If account is inactive, no access
        return $this->checkStatus($user);
    }

    public function sendMessages(UserInterface $user, Chat $chat)
    {
        // If account is inactive, no access
        if (!$this->checkStatus($user)) {
            return false;
        }

        // Ended chat cannot send message
        if ($chat->status === 'ended') {
            return false;
        }

        // Customer can only send to their own chat that is pending or active
        if ($user->getRole() === 'customer') {
            if ($user->getID() === $chat->customer_id) {
                return true;
            }
        }
        // Customer service can only send to chat they are handling
        else if ($user->getRole() === 'customer_service') {
            if ($chat->admin_id === $user->getID() && $chat->status === 'active') {
                return true;
            }
        }

        return false;
    }

    public function createChat(UserInterface $user)
    {
        // If account is inactive, no access
        if (!$this->checkStatus($user)) {
            return false;
        }

        // Only customer can start a chat
        if ($user->getRole() === 'customer') {
            return true;
        }

        return false;
    }

    public function acceptChat(UserInterface $user, Chat $chat)
    {
        // If account is inactive, no access
        if (!$this->checkStatus($user)) {
            return false;
        }

        // Only pending chat can be accepted
        if ($chat->status !== 'pending') {
            return false;
        }

        // Only customer service can accpet a chat
        if ($user->getRole() === 'customer_service') {
            return true;
        }

        return false;
    }

    public function endChat(UserInterface $user, Chat $chat)
    {
        // If account is inactive, no access
        if (!$this->checkStatus($user)) {
            return false;
        }

        // Only active chat can be ended
        if ($chat->status !== 'active') {
            return false;
        }

        // Only customer service can end thier own chat
        if ($user->getRole() === 'customer_service') {
            if ($chat->admin_id === $user->getID()) {
                return true;
            }
        }

        return false;
    }

    public function rateChat(UserInterface $user, Chat $chat)
    {
        // If account is inactive, no access
        if (!$this->checkStatus($user)) {
            return false;
        }

        // Only customer can rate a chat
        if ($user->getRole() === 'customer') {
            if ($user->getID() === $chat->customer_id && $chat->status === 'ended') {
                return true;
            }
        }

        return false;
    }

    // Check status of user before allowing any access
    public function checkStatus(UserInterface $user)
    {
        if ($user->getStatus() === 'active') {
            return true;
        }
        return false;
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Chat;
use App\Policies\ChatPolicy;

class ChatAuthServiceProvider extends ServiceProvider
{

    protected $policies = [
        Chat::class => ChatPolicy::class, 
    ];

    public function boot()
    {
        $this->registerPolicies();

        Gate::define('viewChat', [ChatPolicy::class, 'viewChat']);

        Gate::define('getChatList', [ChatPolicy::class, 'getChatList']);

        Gate::define('sendMessages', [ChatPolicy::class, 'sendMessages']);

        Gate::define('createChat', [ChatPolicy::class, 'createChat']);
        
        Gate::define('acceptChat', [ChatPolicy::class, 'acceptChat']);
       
        Gate::define('endChat', [ChatPolicy::class, 'endChat']);

        Gate::define('generateReport', [ChatPolicy::class, 'generateReport']);
    }
}

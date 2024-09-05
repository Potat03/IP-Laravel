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

        Gate::define('sendMessages', [ChatPolicy::class, 'sendMessages']);

        Gate::define('end', [ChatPolicy::class, 'end']);

        Gate::define('getMessages', [ChatPolicy::class, 'getMessages']);

        Gate::define('viewChat', [ChatPolicy::class, 'viewChat']);

        Gate::define('viewAny', [ChatPolicy::class, 'viewAny']);
        
    }
}

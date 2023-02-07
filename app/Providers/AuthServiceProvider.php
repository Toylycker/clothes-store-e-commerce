<?php

namespace App\Providers;

use App\Models\Chat;
use App\Models\Order;
use App\Models\Outfit;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('add-item', function (User $user, Outfit $outfit) {
            return $user->seller->id === $outfit->seller_id || $user->role == 'admin';
        });

        Gate::define('get-conversation', function (User $user, Chat $chat) {
            return $user->chats->where('id', $chat->id)->first();
        });

        Gate::define('not-to-yourself', function (User $user, User $user2) {
            return $user->id == $user2->id;
        });

        Gate::define('accept-order', function (User $user, Order $order) {
            return $order->seller_id == $user->seller->id;
        });

        //
    }
}

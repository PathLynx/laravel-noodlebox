<?php

namespace App\Providers;


use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Overtrue\LaravelWeChat\Events\WeChatUserAuthorized;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        WeChatUserAuthorized::class => [
            'App\Listeners\Auth\WeChatUserAuthorizedListener'
        ],
        Registered::class => [
            'App\Listeners\Auth\RegisteredListener',
            SendEmailVerificationNotification::class
        ],
        Login::class => [
            'App\Listeners\Auth\LoginListener'
        ],
        Logout::class => [
            'App\Listeners\Auth\LogoutListener'
        ],
        'Illuminate\Auth\Events\Verified' => [
            'App\Listeners\Auth\UserVerifiedListener'
        ],
        'App\Events\OrderChanged' => [
            'App\Listeners\OrderChangedListener'
        ],
        'App\Events\OrderCreated' => [
            'App\Listeners\OrderCreatedListener'
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}

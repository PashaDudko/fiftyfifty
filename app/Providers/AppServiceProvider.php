<?php

namespace App\Providers;

use App\Events\UserRegisteredThroughGoogle;
use App\Listeners\SendGeneratedPasswordMailForUserRegisteredThroughGoogle;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(
            UserRegisteredThroughGoogle::class,
            SendGeneratedPasswordMailForUserRegisteredThroughGoogle::class
        );
    }
}

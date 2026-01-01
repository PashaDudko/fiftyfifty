<?php

namespace App\Listeners;

use App\Events\UserRegisteredThroughGoogle;
use App\Mail\GeneratedPasswordForUserRegisteredThroughGoogle;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendGeneratedPasswordMailForUserRegisteredThroughGoogle
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     */
    public function handle(UserRegisteredThroughGoogle $event): void
    {
        $email = $event->user->email;
        $name = $event->user->name;
        Mail::to($email)->send(new GeneratedPasswordForUserRegisteredThroughGoogle($name, $event->password));
    }
}

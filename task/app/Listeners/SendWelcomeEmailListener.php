<?php

namespace App\Listeners;

use App\Events\UserRegisteredEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Employee;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeEmail;
use lluminate\Contracts\Mail\Mailable;


class SendWelcomeEmailListener implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserRegisteredEvent $event): void
    {
        // dd($event->employee);

    }

    public function shouldQueue(UserRegisteredEvent $event)
    {
        return $event->employee;
        // Mail::to($event->employee)->send(new WelcomeEMail($event->employee));

    }


}

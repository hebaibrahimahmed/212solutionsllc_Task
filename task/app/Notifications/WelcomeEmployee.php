<?php

namespace App\Notifications;

use App\Models\Employee;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeEmployee extends Notification
{
    use Queueable;
    private $employee;
    /**
     * Create a new notification instance.
     */
    public function __construct($employee)
    {
        $this->employee = $employee;
        //
    }
    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */


     public function toMail($notifiable)
     {
         return (new MailMessage)
         ->greeting($this->employee['hello'])
         ->action('Explore',$this->employee['actionurl'] )
         ->line('Thank you for joining our company!');

     }
    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}

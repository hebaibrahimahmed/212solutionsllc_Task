<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Employee;
use App\Notifications\WelcomeEmployee;

class EmployeeCreated
{
    use Dispatchable, SerializesModels;

    public $employee;


    public function __construct(Employee $employee)
    {
        dd('Event Fired');
        $this->employee = $employee;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */

    public function broadcastOn():array
{
    return [
        new WelcomeEmployee($this->employee)
   ];
}
}

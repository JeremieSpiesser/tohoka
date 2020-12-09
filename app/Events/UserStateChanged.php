<?php


namespace App\Events;


use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserStateChanged implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $room;
    public $id;
    public $state;

    public function __construct(string $room, string $id, string $state)
    {
        $this->room = $room;
        $this->id = $id;
        $this->state = $state;
    }

    public function broadcastOn()
    {
        return new PresenceChannel('playquizz.' . $this->room);
    }
}

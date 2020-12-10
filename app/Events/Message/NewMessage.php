<?php

namespace App\Events\Message;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $sender;
    public $message;
    public $date;
    public $room;

    /**
     * Create a new event instance.
     *
     * @param string $sender
     * @param string $message
     * @param string $date
     * @param string $room
     */
    public function __construct(string $sender, string $message, string $date, string $room)
    {
        $this->sender = $sender;
        $this->message = $message;
        $this->date = $date;
        $this->room = $room;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\PresenceChannel|array
     */
    public function broadcastOn()
    {
        return new PresenceChannel('room.' . $this->room);
    }
}

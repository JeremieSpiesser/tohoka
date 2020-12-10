<?php


namespace App\Events;


use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NextQuestion implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $room;
    public $idQuestion;

    public function __construct(string $room, string $idQuestion)
    {
        $this->room = $room;
        $this->idQuestion = $idQuestion;
    }

    public function broadcastOn()
    {
        return new PresenceChannel('playquizz.' . $this->room);
    }
}

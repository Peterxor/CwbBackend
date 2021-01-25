<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MobileActionEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $room = null;
    public $screen = null;
    public $sub = null;
    public $behaviour = null;
    public $point_x = null;
    public $point_y = null;
    public $scale = null;
    public function __construct($room, $screen, $sub, $behaviour, $point_x, $point_y, $scale)
    {
        //
        $this->room = $room;
        $this->screen = $screen;
        $this->sub = $sub;
        $this->behaviour = $behaviour;
        $this->point_x = $point_x;
        $this->point_y = $point_y;
        $this->scale = $scale;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('mobile_event');
    }

    public function broadcastWith()
    {
        return [
            'room' => $this->room,
            'screen' => $this->screen,
            'sub' => $this->sub,
            'behaviour' => $this->behaviour,
            'point_x' => $this->point_x,
            'point_y' => $this->point_y,
            'scale' => $this->scale,
        ];
    }
}

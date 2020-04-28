<?php

namespace App\Events;

use App\Message;
use Carbon\Carbon;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MessageReceived
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $message;
    private $userId;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($message, $userId = 0)
    {
        $this->message = $message;
        $this->userId = $userId;
    }

    /**
     * Get the message data
     *
     * return App\Message
     */
    public function getData()
    {
        $model = new Message();
        $model->room_id = $this->message->room_id;
        $model->msg = $this->message->type == 'text' ? $this->message->content : '';
        $model->img = $this->message->type == 'image' ? $this->message->image : '';
        $model->user_id = $this->userId;
        $model->created_at = Carbon::now();
        return $model;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}

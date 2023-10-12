<?php

namespace App\Events\Product;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CsvUploadHistoryEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $upload_history;

    public function __construct($upload_history)
    {
        $this->upload_history = $upload_history;
    }


    public function broadcastAs() {
        return 'UploadHistoryEvent';
    }


    public function broadcastOn(): array
    {
        return [
            new Channel('public-upload-history'),  //need to change later as private channel
        ];
    }


    public function broadcastWith()
    {
        return [
            'upload_history' => $this->upload_history,
        ];
    }


}





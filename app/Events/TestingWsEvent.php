<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TestingWsEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public $test_message;
  
    public function __construct($test_message) {
      $this->test_message = $test_message;
    }

   
    public function broadcastAs() {
        return 'TestEvent';
    }
    

    public function broadcastOn(): array
    {
        return [
            new Channel('public-test-channel'),
        ];
    }


     public function broadcastWith()
    {
        return [
            'test_message' => $this->test_message,
        ];
    }
}

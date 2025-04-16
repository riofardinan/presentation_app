<?php

namespace App\Events;

use App\Models\Tutorial;
use Illuminate\Support\Facades\Log;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class DetailUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    
    public $tutorial_id;
    public $url_presentation;

    public function __construct($tutorial_id)
    {
        $this->tutorial_id = $tutorial_id;

        $tutorial = Tutorial::find($tutorial_id);
        $this->url_presentation = $tutorial ? route('presentation', $tutorial->presentation)  : null;

        // Log::info("Event DetailUpdated dipanggil dengan tutorial_id: " . $tutorial_id);
    }

    public function broadcastOn()
    {
        return new Channel('detail-channel');
    }

    public function broadcastAs()
    {
        return 'detail-updated';
    }

    public function broadcastWith()
    {
        // Log::info("Menyiarkan event dengan url_presentation: " . $this->url_presentation);
        return [
            'url_presentation' => $this->url_presentation
        ];
    }
}

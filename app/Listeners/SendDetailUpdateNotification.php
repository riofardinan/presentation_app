<?php

namespace App\Listeners;

use App\Models\Tutorial;
use App\Events\DetailUpdated;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendDetailUpdateNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(DetailUpdated $event)
    {
        
    }
}

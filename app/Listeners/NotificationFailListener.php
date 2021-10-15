<?php

namespace App\Listeners;

use App\Events\NotificationFail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Models\NotificationLog;

class NotificationFailListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  NotificationFail  $event
     * @return void
     */
    public function handle(NotificationFail $event)
    {
        $log = ["result" => "notification could not be sent due to: ". $event->log["error"]];
        NotificationLog::create(array_merge($log,$event->log));
    }
}

<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;


use App\Events\NotificationSending; 
use App\Models\NotificationLog;

class NotificationSendingListener implements ShouldQueue
{
    
    public $tries = 5;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    public function backoff()
    {
        return [1, 5, 10,15,20];
    }
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(NotificationSending $event)
    {
        $log = ["result" => "notification has begin sending"];
        NotificationLog::create(array_merge($event->log,$log));
    }
    public function failed($event, $exc)
    {
        $log = new NotificationLog();
        $log->channel_provider_id = 1;
        $log->channel_type_id = 1;
        $log->notification_type_id = 1;
        $log->result = "let see";
        $log->content = "content of message";
        $log->recipient = "var";
        $log->variables = json_encode(["first_name" => "Uzezi"]);
        $log->save();

    }
}

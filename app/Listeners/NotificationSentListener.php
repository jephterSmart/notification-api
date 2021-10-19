<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Events\NotificationSent; 

use App\Models\NotificationLog;

class NotificationSentListener implements ShouldQueue
{
    use InteractsWithQueue;
    public $tries = 3;
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
    public function handle(NotificationSent $event)
    {
        $log = ["result" => "notification was sent successfully"];
        $num = rand(1,10);
        // if($num < 7){
        //     $this->fail();
        // }
       $logs = NotificationLog::create(array_merge($log,$event->log));
    }
    // public function shouldQueue(){
    //     return false;
    // }
    public function failed(NotificationSent $event, \Throwable $err)
    {
        $log = ["result" => $err->getMessage()];
        NotificationLog::create(array_merge($event->log, $log));
    }
}

<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Events\NotificationSending;
use App\Models\NotificationLog;

class TestController extends Controller
{
    public function test()
    {
        // $log = new NotificationLog();
        // $log->channel_provider_id = 1;
        // $log->channel_type_id = 1;
        // $log->notification_type_id = 1;
        // $log->result = "sent from controller";
        // $log->content = "content of message";
        // $log->recipient = "var";
        // $log->variables = json_encode(["first_name" => "Uzezi"]);
        // $log->save();
        $log = [
            "channel_provider_id" => 1,
            "channel_type_id" => 1,
            "notification_type_id" => 1,
            "recipient" => "oghenekaro@gmail.com",
            "result" => "message sent successfully",
            "content" => "Hello oghenekaro",
            "variables" => "{first:Karo}"
        ];
        NotificationSending::dispatch($log);
        return response()->json( ["message"=>"notification has been sent"],200);
    }
}

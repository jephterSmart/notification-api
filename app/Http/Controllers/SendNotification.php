<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loyalty;
use App\Models\NotificationType;
use App\Models\EmailGroup;
use App\Models\ChannelProvider;
use App\Models\ChannelConfig;
use App\Models\Template;

use App\Mail\SmtpMail;
use App\Events\NotificationSent;
use App\Events\NotificationSending;
use App\Events\NotificationFail;

use Illuminate\Support\Facades\Mail;


class SendNotification extends Controller
{
    const EMAIL_TYPE = 1;
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sendSingle(Request $request, $program_slug)
    {
        $request->validate([
            "recipient" => 'required|string',
            "variables" => 'required|array',
            "variables.*" => 'required|string',
            "immediate" => 'nullable|string',
            "not_slug" =>'required|string'
        ]);
        $program = Loyalty::where("slug",$program_slug)->first();
        if(!$program){
            return response()->json([
                "message" => "No program was selected",
                "status" => 0
            ],403);
        }
        $request->programId = $program->id;
        $notTypes = NotificationType::where([
            ["slug", $request->not_slug],
            ["loyalty_id", $request->programId]
        ])->get();
        if(!$notTypes){
            return response()->json([
                "message" => "No notification type was selected",
                "status" => 0
            ],403);
        }
        $configs = [];
        $notProvidersConfNotProvided = [];
        foreach($notTypes as $key => $notType){
          $configs[] =  ChannelConfig::where("loyalty_id",$request->programId)
            ->where("channel_provider_id", $notType->channel_provider_id)->first();
            if(is_null($configs[$key])){
                $notProvidersConfNotProvided[] = $notType->channel_provider_id;
            }
        }
        foreach($configs as $config ){
            if(is_null($config)){
                return response()->json([
                    "message" => "There are no configuaration set for the provider(s) with ids" . 
                    implode(", ",$notProvidersConfNotProvided) . "selected to send notification",
                    "status" => 0
                ],403);
            }
           
        }
       $templates = $this->grabTemplates($request,$notTypes);

        $responses = $this->send($request->recipient, $templates,$request->immediate,$configs);
       return response()->json([
           "message" =>"notification has been sent",
           "data" => $responses
       ],200);
        
    }//end of invokable
    private function grabTemplates($request, $notTypes)
    {
        $programId = $request->programId;
        $variables = $request->variables;
        $templates = [];
        foreach($notTypes as $key => $notType)
        {
            $templates[] = Template::where([
                ["loyalty_id",'=',$programId],
                ["channel_provider_id", '=',$notType->channel_provider_id],
                ["notification_type_id",'=',$notType->id]
            ])->first();
            if(is_null($templates[$key])){
                return response()->json([
                    "message" => "No template configured for this notification type ({$notType->name}) and provider({$notType->channel_provider_id}) pair",
                    "status" => 0
                ],403);
            }
        }
        $request->templates = $templates;
        $templates = $this->addVariables($templates,$variables);
        return $templates;
    }//end
    private function addVariables($templates,$variables)
    {
    
        foreach($templates as $template){
            
            foreach($variables as $key => $value){
                $content = str_replace('$'."{$key}", $value, $template->content);
            }
            $template->content = $content;
        }
        return $templates;

    }//end
    private function send($recipient,$templates,$immediate,$configs)
    {
        $channelTypes = [];
        foreach($templates as  $template){
            $channelType= ChannelProvider::find($template->channel_provider_id)
            ->channel_type_id;
            $channelTypes[] = $channelType;
            NotificationSending::dispatch([
                "channel_provider_id" => $template->channel_provider_id,
                "channel_type_id" => $channelType,
                "notification_type_id" => $template->notification_type_id,
                "recipient" => $recipient,
                "content" => $template->content,
                "variables" => json_encode(request()->variables)
            ]);
            if($channelType == self::EMAIL_TYPE){
                $response[] = $this->viaEmail($recipient,$template,$immediate,$configs);
            }
            else{
                $response[] = $this->viaSMS($recipient,$template,$immediate,$configs);
            }
        }
        return $response;
        
    }//end
    private function viaEmail($recipient,$template,$immediate,$configs)
    {
        
        $notType = NotificationType::find($template->notification_type_id);
        $conf;
        foreach($configs as $config){
            if($config->loyalty_id == $notType->loyalty_id && 
                $config->channel_provider_id == $notType->channel_provider_id){
                    $conf = $config;
                }
        }
        $mail = Mail::to($recipient);
        $groups = $notType->groups->map(function($item){
            return ["{$item->pivot->email_copy}" => $item->id];
        })->reduce(function($acc,$item){
            foreach($item as $key => $value){
                if(isset($acc[$key])){
                    array_push($acc[$key],$value);
                    
                }
                else{
                    $acc[$key] = [$value];
                }
                return $acc;
            }
        },[]);
        $emails=[];
        foreach($groups as $key => $groupIds){
            foreach($groupIds as $groupId){
               $_emails =  EmailGroup::find($groupId)->addresses->toArray();
                //This ensures that emails are sent once
                $emails[] = array_merge($_emails,$emails );
            }
            $groups[$key] = $emails;
            $emails = [];
        }
        if(count($groups["bcc"])){
            $mail->bcc($groups["bcc"]);
        }
        if(count($groups["cc"])){
            $mail->cc($groups["cc"]);
        }
        $channelType = ChannelProvider::find($template->channel_provider_id)->channel_type_id;
        $variable = json_decode($conf->config);
        config([
            "mail.mailers.smtp.host" => $conf->host,
            "mail.mailers.smtp.username" => $variable->username,
            "mail.mailers.smtp.password" => $variable->password,
            "mail.mailers.smtp.port" => $variable->port,
            "mail.mailers.smtp.encryption" => $variable->encryption
        ]);
        if($immediate == "true"){
            try{
                $mail->send(new SmtpMail($template));
                NotificationSent::dispatch([
                    "channel_provider_id" => $template->channel_provider_id,
                    "channel_type_id" => $channelType,
                    "notification_type_id" => $template->notification_type_id,
                    "recipient" => $recipient,
                    "content" => $template->content,
                    "variables" => json_encode(request()->variables)

                ]);
                return (object)[
                    "status"=>1,
                    "message"=>"message has been sent succesfully"
                ];
            }catch(\Exception $err){
                NotificationFail::dispatch([
                    "error" => $err->getMessage(),
                    "channel_provider_id" => $template->channel_provider_id,
                    "channel_type_id" => $channelType,
                    "notification_type_id" => $template->notification_type_id,
                    "recipient" => $recipient,
                    "content" => $template->content,
                    "variables" => json_encode(request()->variables)
                ]);
                return (object)[
                    "status"=>0,
                    "message"=>"message fail due to error:" . $err->getMessage()
                ];
            }
            
        }
        else{
            try{
                $mail->later(now()->addSeconds(5),new SmtpMail($template));
               
                NotificationSent::dispatch([
                    "channel_provider_id" => $template->channel_provider_id,
                    "channel_type_id" => $channelType,
                    "notification_type_id" => $template->notification_type_id,
                    "recipient" => $recipient,
                    "content" => $template->content,
                    "variables" => json_encode(request()->variables)
                ]);
                return (object)[
                    "status"=>1,
                    "message"=>"message has been sent succesfully"
                ];
            }catch(\Exception $err){
                NotificationFail::dispatch([
                    "error" =>  $err->getMessage(),
                    "channel_provider_id" => $template->channel_provider_id,
                    "channel_type_id" => $channelType,
                    "notification_type_id" => $template->notification_type_id,
                    "recipient" => $recipient,
                    "content" => $template->content,
                    "variables" => json_encode(request()->variables)
                ]);
                return (object)[
                    "status"=>0,
                    "message"=>"message fail due to error:" . $err->getMessage()
                ];
            }
        }

    }//end

}



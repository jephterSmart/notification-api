<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class NotificationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("notification_types")->insert([
            [ "name" => "Enrollment Notification", "slug" => Str::slug("Enrollment notification"), 
            "sender_name" => "First Bank", "sender_email" => "createsurveys@rewardsboxnigeria.com", 
            "channel_provider_id" => 1, "loyalty_id" => 1, "reply_to" => "oghenekaro@loyaltysolutionsnigeria.com"],
           
        ]);
    }
}

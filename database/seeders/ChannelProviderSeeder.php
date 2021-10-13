<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ChannelProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("channel_providers")->insert([
            ["name" => "Email SMTP", "slug" => Str::slug("Email SMTP"), "channel_type_id" => 1, "class_name" =>"\\App\\Utils\\Channels\\EmailSmtp"],
            ["name" => "Email API", "slug" => Str::slug("Email API"), "channel_type_id" => 1,"class_name" =>"\\App\\Utils\\Channels\\EmailApi"],
            ["name" => "SMS API", "slug" => Str::slug("SMS API"), "channel_type_id" => 2,"class_name" =>"\\App\\Utils\\Channels\\SMSApi"],

        ]);
    }
}

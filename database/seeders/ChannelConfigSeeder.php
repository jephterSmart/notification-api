<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;


class ChannelConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("channel_configs")->insert([
            ["host" =>"mail.rewardsboxnigeria.com " , "config" =>json_encode([
                "username" => "createsurveys@rewardsboxnigeria.com", "password" => "cy;bi+3?TXO!", "port" => 587, "encryption" => ""
            ]) , "channel_provider_id" => 1, "loyalty_id" => 1],
           
        ]);
    }
}

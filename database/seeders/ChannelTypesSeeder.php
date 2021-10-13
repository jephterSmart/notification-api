<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class ChannelTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("channel_types")->insert([
            ["name" => "Email", "slug" => Str::slug("Email type")],
            ["name" => "SMS", "slug" => Str::slug("SMS type")]
        ]);
    }
}

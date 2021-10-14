<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmailGroupNotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('email_group_notifications')->insert([
            ["notification_type_id" => 1,"email_group_id" => 1,"email_copy" =>"bcc"],
            ["notification_type_id" => 1,"email_group_id" => 3,"email_copy" =>"cc"],
            ["notification_type_id" => 1,"email_group_id" => 2,"email_copy" =>"bcc"]
        ]);
    }
}

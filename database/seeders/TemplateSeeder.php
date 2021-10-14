<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("templates")->insert([
            ["channel_provider_id" => 1, "loyalty_id" => 1, "notification_type_id" => 1,
            "subject" => "Enrollment Notification successful", "name" => "enrollment template", 
            "content"=>" <html>Hello \$first_name \$last_name. You have been enrolled successfully</html>"]
        ]);
    }
}

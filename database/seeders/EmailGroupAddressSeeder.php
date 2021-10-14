<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class EmailGroupAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('email_group_addresses')->insert([
            ["email_group_id" => 1,"email_address_id" => 1],
            ["email_group_id" => 1,"email_address_id" => 2],
            ["email_group_id" => 1,"email_address_id" => 3],
            ["email_group_id" => 2,"email_address_id" =>1],
            ["email_group_id" => 2,"email_address_id" => 3],
            ["email_group_id" => 3,"email_address_id" => 4]
        ]);
    }
}

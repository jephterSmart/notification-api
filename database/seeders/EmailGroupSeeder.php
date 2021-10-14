<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class EmailGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('email_groups')->insert([
            ["name" => "Test Group","loyalty_id" =>1],
            ["name" => "Reference Group","loyalty_id" =>2],
            ["name" => "Client Group","loyalty_id" =>1]
        ]);
    }
}

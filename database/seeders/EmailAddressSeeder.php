<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class EmailAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('email_addresses')->insert([
            ["email" => "adeoye@loyaltysolutionsnigeria.com","loyalty_id" =>1],
            ["email" => "uchenna@loyaltysolutionsnigeria.com","loyalty_id" =>1],
            ["email" => "damilola@loyaltysolutionsnigeria.com","loyalty_id" =>1],
            ["email" => " olayinka@loyaltysolutionsnigeria.com","loyalty_id" =>1]
        ]);
    }
}

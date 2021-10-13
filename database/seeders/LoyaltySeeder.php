<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LoyaltySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('loyalties')->insert([
            ["name" => "Customer program", "slug" => Str::slug("Customer program")],
            ["name" => "Employee program", "slug" => Str::slug("Employee program")]
        ]);  
    }
}

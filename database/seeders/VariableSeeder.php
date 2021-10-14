<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class VariableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("variables")->insert([
            ["name" => "First Name", "key" => "first_name", "description" => "The first name of user"],
            ["name" => "Last Name", "key" => "last_name","description" => "The last name of users"],
            ["name" => "Image File", "key" => "image", "type" => "image"],
        ]);
    }
}

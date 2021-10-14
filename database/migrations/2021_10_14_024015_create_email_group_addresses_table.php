<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailGroupAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_group_addresses', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->foreignId("email_group_id")
                ->constrained("email_groups");
            $table->foreignId("email_address_id")->constrained("email_addresses");
            $table->timestamp("created_at")->default(now());
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('email_group_addresses');
    }
}

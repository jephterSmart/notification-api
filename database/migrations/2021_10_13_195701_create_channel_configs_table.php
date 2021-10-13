<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChannelConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('channel_configs', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger("status")->default(1);
            $table->string("host");
            $table->json("config");
            $table->foreignId("channel_provider_id")
                ->constrained("channel_providers");
            $table->foreignId("loyalty_id")
                ->constrained("loyalties");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('channel_configs');
    }
}

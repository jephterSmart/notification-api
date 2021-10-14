<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_logs', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->foreignId("channel_provider_id")->constrained();
            $table->foreignId("channel_type_id")->constrained();
            $table->foreignId("notification_type_id")->constrained();
            $table->string("recipient");
            $table->string("result");
            $table->longText("content");
            $table->json("variables");
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
        Schema::dropIfExists('notification_logs');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailGroupNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_group_notifications', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->foreignId("notification_type_id")
                ->constrained();
            $table->foreignId("email_group_id")->constrained();
            $table->string("email_copy");
            $table->timestamp("created_at");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('email_group_notifications');
    }
}

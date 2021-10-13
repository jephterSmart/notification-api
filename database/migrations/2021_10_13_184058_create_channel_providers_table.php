<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChannelProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('channel_providers', function (Blueprint $table) {
            $table->id();
            $table->foreignId("channel_type_id")
                ->constrained()
                ->onUpdate('cascade');
            $table->string("name");
            $table->string("slug")->collation('utf8mb4_unicode_ci');
            $table->tinyInteger("status")->default(1);
            $table->string("class_name")
            ->comment("The physial class name to call to carry out the particular functionality,i.e, sending mails or sms");
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
        Schema::dropIfExists('channel_providers');
    }
}

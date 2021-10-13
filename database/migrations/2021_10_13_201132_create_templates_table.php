<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('templates', function (Blueprint $table) {
            $table->id();
            $table->foreignId("channel_provider_id")
                ->constrained();
            $table->foreignId("loyalty_id")
                ->constrained("loyalties");
            $table->foreignId("notification_type_id")
                  ->constrained();
            $table->longText("content");
            $table->tinyInteger("status")->default(1);
            $table->string("subject");
            $table->string("name");
            $table->text("description")->nullable();
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
        Schema::dropIfExists('templates');
    }
}

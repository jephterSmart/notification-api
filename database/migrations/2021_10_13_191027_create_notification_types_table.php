<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_types', function (Blueprint $table) {
            $table->id();
            $table-foreignId("loyalty_id")
                  ->constrained("loyalties")
                  ->onUpdate("cascade")
                  ->onDelete("cascade");
            $table->foreignId("channel_provider_id")
                    ->constrained()
                    ->onUpdate("cascade");
            $table->string("slug")->collation('utf8mb4_unicode_ci');
            $table->string("name");
            $table->string("sender_name")->collation('utf8mb4_unicode_ci');
            $table->string("sender_email")->collation('utf8mb4_unicode_ci');
            $table->string("reply_to")->collation('utf8mb4_unicode_ci')->nullable();
            $table->tinyInteger("status")->default(1);
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
        Schema::dropIfExists('notification_types');
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            LoyaltySeeder::class,
            ChannelTypesSeeder::class,
            ChannelProviderSeeder::class,
            ChannelConfigSeeder::class,
            NotificationTypeSeeder::class,
            TemplateSeeder::class,
            VariableSeeder::class,
            EmailAddressSeeder::class,
            EmailGroupSeeder::class,
            EmailGroupAddressSeeder::class,
            EmailGroupNotificationSeeder::class
        ]);
    }
}

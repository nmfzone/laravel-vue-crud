<?php

use Laravel\Passport\Client;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class PassportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Artisan::call('passport:install');

        $client = Client::find(2);

        updateDotEnv([
            'APP_CLIENT_ID' => $client->id,
            'APP_CLIENT_SECRET' => $client->secret,
        ]);
    }
}

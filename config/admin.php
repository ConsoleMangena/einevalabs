<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Panel administrator seed
    |--------------------------------------------------------------------------
    |
    | Used only by database/seeders/DatabaseSeeder.php to create the first
    | Filament administrator. Kept in config/ rather than read with env() in
    | the seeder so it still resolves after `php artisan config:cache`, when
    | the .env file is no longer loaded.
    |
    | Rotate ADMIN_PASSWORD after the first deploy: it is a seed-time value
    | and is not needed at runtime.
    |
    */

    'email' => env('ADMIN_EMAIL'),
    'name' => env('ADMIN_NAME', 'Administrator'),
    'password' => env('ADMIN_PASSWORD'),

];

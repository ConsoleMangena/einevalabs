<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->seedAdministrator();
    }

    /**
     * Create the panel administrator.
     *
     * This previously did an unconditional updateOrCreate() that wrote a
     * hardcoded password on every run, so `php artisan db:seed --force` against
     * production silently reset the admin credential to a string that is
     * public in the repository. The password now comes from the environment,
     * is only set when the account is actually being created, and the seeder
     * refuses to invent one.
     *
     * The values are read through config() rather than env(): after
     * `php artisan config:cache` the .env file is no longer loaded, so a bare
     * env() here would silently return null on any cached deployment and skip
     * the seed without an error.
     */
    private function seedAdministrator(): void
    {
        $email = config('admin.email');
        $password = config('admin.password');

        if (blank($email)) {
            $this->command?->warn('ADMIN_EMAIL is not set; skipping administrator seed.');

            return;
        }

        if (User::where('email', $email)->exists()) {
            $this->command?->info("Administrator {$email} already exists; leaving the existing password untouched.");

            return;
        }

        if (blank($password)) {
            $this->command?->error('ADMIN_PASSWORD is not set; refusing to create an administrator with a blank password.');

            return;
        }

        $this->command?->info("Creating administrator {$email}.");

        User::create([
            'name' => config('admin.name', 'Administrator'),
            'email' => $email,
            // User casts `password` to 'hashed', which hashes on assignment.
            // Hash::make() here would hash a hash and lock the account out
            // behind a password nobody can type.
            'password' => $password,
            'is_admin' => true,
        ]);

        // The cast only fires for attributes that are in $fillable, and
        // email_verified_at is deliberately not, so it is set explicitly.
        User::where('email', $email)->update(['email_verified_at' => now()]);
    }
}

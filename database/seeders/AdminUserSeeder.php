<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $adminEmail = env('ADMIN_EMAIL', 'admin@example.com');
        $adminPassword = env('ADMIN_PASSWORD', 'secret123');

        if (!User::where('email', $adminEmail)->exists()) {
            User::create([
                'name' => 'Admin',
                'email' => $adminEmail,
                'password' => Hash::make($adminPassword),
                'email_verified_at' => now(),
                'is_admin' => true,  
            ]);

            $this->command->info(" Admin created: {$adminEmail}");
        } else {
            // Update existing admin
            User::where('email', $adminEmail)->update(['is_admin' => true]);
            $this->command->info("Admin updated: {$adminEmail}");
        }
    }
}

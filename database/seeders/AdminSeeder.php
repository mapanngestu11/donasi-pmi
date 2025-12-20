<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cek apakah user admin sudah ada
        $admin = User::where('email', 'admin@pmi.com')->first();
        
        if (!$admin) {
            User::create([
                'name' => 'Administrator',
                'email' => 'admin@pmi.com',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]);
            
            $this->command->info('Admin user created successfully!');
            $this->command->info('Email: admin@pmi.com');
            $this->command->info('Password: password123');
        } else {
            // Update password jika user sudah ada
            $admin->update([
                'password' => Hash::make('password123'),
            ]);
            
            $this->command->info('Admin user password updated!');
            $this->command->info('Email: admin@pmi.com');
            $this->command->info('Password: password123');
        }
    }
}


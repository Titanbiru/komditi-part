<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::updateOrCreate([
            'email' => 'komditi@gmail.com',
        ], [
            'name' => 'Admin Komditi',
            'password' => Hash::make('admin12345'),
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $settings = [
            ['key' => 'hero_image', 'value' => 'hero-default.jpg'],
            ['key' => 'bank_name', 'value' => 'BCA'],
            ['key' => 'bank_account', 'value' => '1234567890'],
            ['key' => 'bank_holder', 'value' => 'PT KOMDITI PART'],
            ['key' => 'qris_image', 'value' => 'qris-default.jpg'],
            ['key' => 'shop_address', 'value' => 'Jakarta, Indonesia'],
            ['key' => 'admin_fee', 'value' => '2500'], // Sekalian buat biaya admin biar dinamis
        ];
    
        foreach ($settings as $setting) {
            \App\Models\Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}

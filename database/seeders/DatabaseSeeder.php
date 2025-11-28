<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Md. Shakil Khan',
            'email' => 'mdshakil.khan8032@gmail.com',
            'password' => Hash::make('12345678'),
            'is_admin' => true,
        ]);

        Setting::create([
            'site_title' => 'Shakil Portfolio',
            'hero_title' => "Hi, I'm Shakil",
            'hero_subtitle' => 'Full Stack Web Developer',
            'about' => 'Brief bio about yourself...',

        ]);
    }
}

<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        \App\Models\User::create([
            'name' => 'Admin Macawa', 
            'email' => 'admin@gmail.com',
            'password' => 'password',
            'is_admin' => 1
        ]);

        \App\Models\User::create([
            'name' => 'Owner Macawa', 
            'email' => 'owner@gmail.com',
            'password' => 'password',
        ]);
    }
}

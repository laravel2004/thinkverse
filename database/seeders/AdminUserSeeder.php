<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::firstOrCreate(
            ['email' => 'admin@thinkverse.com'],
            [
                'name' => 'Admin Utama',
                'password' => bcrypt('password'),
                'role' => 'admin',
            ]
        );
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->updateOrInsert(
            ['email' => 'admin@ngadubose.test'], 
            [
                'name' => 'Admin Utama BPS',
                'password' => Hash::make('admin123'), 
                'is_admin' => 1, 
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
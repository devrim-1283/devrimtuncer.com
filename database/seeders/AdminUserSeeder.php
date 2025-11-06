<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Devrim Tuncer',
            'email' => 'admin@devrimtuncer.com',
            'password' => Hash::make('admin123'), // Change this password!
            'email_verified_at' => now(),
        ]);
    }
}

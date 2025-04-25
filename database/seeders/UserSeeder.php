<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'username' => 'developer',
            'password' => Hash::make('Test@Password123#'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

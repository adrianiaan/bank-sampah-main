<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user_default_value = [
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ];

        $superadmin = User::create(array_merge([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'password' => Hash::make('8Delapan'),
            'role' => 'super_admin',
        ], $user_default_value));

        $kepalaDinas = User::create(array_merge([
            'name' => 'Kepala Dinas',
            'email' => 'kepaladinas@example.com',
            'password' => Hash::make('8Delapan'),
            'role' => 'kepala_dinas',
        ], $user_default_value));

        $endUser = User::create(array_merge([
            'name' => 'End User',
            'email' => 'enduser@example.com',
            'password' => Hash::make('8Delapan'),
            'role' => 'end_user',
        ], $user_default_value));
    }
}

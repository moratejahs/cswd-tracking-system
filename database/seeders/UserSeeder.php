<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'first_name' => "Admin",
            'middle_name' => "Admin",
            'last_name' => "Admin",
            'email' => "admin@gmail.com",
            'position' => "Administrator",
            'username' => 'admin123',
            'password' => '1234',
        ]);
    }
}

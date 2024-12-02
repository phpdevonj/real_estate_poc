<?php

namespace Database\Seeders;

use DB;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'role' => '0',
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'), // Use a secure password
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

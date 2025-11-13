<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (User::count() === 0) {
            User::create([
                'name' => 'Admin',
                'email' => 'milo@schoonsoft.test',
                'password' => Hash::make('Wecandobeter!!'),
            ]);
        }
    }
}

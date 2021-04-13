<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(1)->create([
            'name' => 'admin',
            'email' => 'admin@vascomm.test',
            'is_admin' => true,
            'password' => Hash::make('password')
        ]);
        \App\Models\User::factory(5)->create([
            'is_admin' => false,
            'password' => Hash::make('password')
        ]);
    }
}

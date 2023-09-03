<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed buckhill admin information

        User::factory()->create([
            'first_name' => 'Buck',
            'last_name' => 'Hill',
            'email' => 'admin@buckhill.co.uk',
            'password' => 'admin',
            'is_admin' => 1
        ]);

        User::factory(10)->create();
    }
}

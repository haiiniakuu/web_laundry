<?php

namespace Database\Seeders;

use App\Models\Level;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Level::factory()->create(['level_name' => 'Administrator']);
        Level::factory()->create(['level_name' => 'Operator']);
        Level::factory()->create(['level_name' => 'Pimpinan']);

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'id_level' => 1
        ]);
        User::factory()->create([
            'name' => 'Operator',
            'email' => 'operator@example.com',
            'password' => bcrypt('password'),
            'id_level' => 2
        ]);
        User::factory()->create([
            'name' => 'Pimpinan',
            'email' => 'pimpinan@example.com',
            'password' => bcrypt('password'),
            'id_level' => 3
        ]);
    }
}

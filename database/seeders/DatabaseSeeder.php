<?php

namespace Database\Seeders;

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
        $user = User::where('email', 'test@example.com')->first();
        if (is_null($user)) {
            User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);
        }

        $this->call([
            // Other seeders if any
            CategorySeeder::class, // Call your custom seeder here
            ProductSeeder::class, // Call your custom seeder here
        ]);
    }
}

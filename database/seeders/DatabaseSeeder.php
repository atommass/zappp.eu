<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Link;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $user = \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'), // Login with: password
        ]);

        try {
            Link::factory()
                ->count(10)
                ->for($user)
                ->has(\App\Models\Redirect::factory()->count(3))
                ->create();
            echo "Links created successfully\n";
        } catch (\Exception $e) {
            echo "Error creating links: " . $e->getMessage() . "\n";
            throw $e;
        }
    }
}

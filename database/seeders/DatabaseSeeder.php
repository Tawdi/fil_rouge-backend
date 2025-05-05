<?php

namespace Database\Seeders;

use App\Models\Genre;
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

        User::factory()->create([
            'name' => 'admin super',
            'email' => 'movieseat@super.com',
            'password'=> 'password',
            'role'=>'super_admin'
        ]);
        // List of genre names
        $genres = ['Horror', 'Sci-Fi', 'Romance', 'Action', 'Comedy', 'Drama', 'Thriller', 'Animation', 'Fantasy', 'Documentary'];

        // Create genres using the factory
        foreach ($genres as $genreName) {
            Genre::factory()->create([
                'name' => $genreName,
            ]);
        }

        $this->call([
            MovieSeeder::class,
        ]);
    }
}

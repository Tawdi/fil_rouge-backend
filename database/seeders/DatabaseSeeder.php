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
        Genre::factory()->create([
            'name' => 'Horror',
        ]);
        Genre::factory()->create([
            'name' => 'Sci-Fi',
        ]);
        Genre::factory()->create([
            'name' => 'Romance',
        ]);

        $this->call([
            MovieSeeder::class,
        ]);
    }
}

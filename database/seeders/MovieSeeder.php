<?php

namespace Database\Seeders;

use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class MovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Assume genre id = 1 exists
        // Movie::factory()->count(5)->create([
        //     'genre_id' => 1,
        // ]);

        $response = Http::get('https://yts.mx/api/v2/list_movies.json?genre=Crime&sort_by=rating&page=1');
        $movies = $response->json('data.movies');

        if (!$movies) {
            $this->command->error('No movies found from YTS API');
            return;
        }
        $genreIds = Genre::pluck('id')->toArray(); 
        foreach ($movies as $movie) {
            
            Movie::factory()->create([
                'titre' => $movie["title"],
                'rating' => $movie["rating"],
                'poster' => $movie["medium_cover_image"],
                'background' => $movie["background_image"],
                'genre_id' => fake()->randomElement($genreIds),
                ]);
        }

        $response = Http::get('https://yts.mx/api/v2/list_movies.json?genre=Crime&sort_by=rating&page=2');
        $movies = $response->json('data.movies');

        if (!$movies) {
            $this->command->error('No movies found from YTS API');
            return;
        }

        foreach ($movies as $movie) {
            
            Movie::factory()->create([
                'titre' => $movie["title"],
                'duration' => $movie["runtime"] || 120,
                'rating' => $movie["rating"],
                'poster' => $movie["medium_cover_image"],
                'background' => $movie["background_image"],
                'genre_id' => 1,
                ]);
        }

        $response = Http::get('https://yts.mx/api/v2/list_movies.json?genre=Crime&sort_by=rating&page=4');
        $movies = $response->json('data.movies');

        if (!$movies) {
            $this->command->error('No movies found from YTS API');
            return;
        }

        foreach ($movies as $movie) {
            
            Movie::factory()->create([
                'titre' => $movie["title"],
                'duration' => $movie["runtime"] || 120,
                'rating' => $movie["rating"],
                'poster' => $movie["medium_cover_image"],
                'background' => $movie["background_image"],
                'genre_id' => 1,
                ]);
        }
    }
}

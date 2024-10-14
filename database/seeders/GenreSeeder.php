<?php

namespace Database\Seeders;

use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Genre::factory(10)->create();

        $this->linkEachMovieToGenres();

    }

    private function linkEachMovieToGenres()
    {
        $movies = Movie::all();
        $genres = Genre::all();

        foreach($movies as $movie) 
        {
            $numberOfGenres = rand(1, 4);
            $randomGenres = $genres->random($numberOfGenres);
            $movie->genres()->sync($randomGenres);
        }
    }
}

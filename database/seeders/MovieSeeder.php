<?php

namespace Database\Seeders;

use App\Models\Movie;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a single specific movie
        Movie::create([
            'name' => 'The Matrix',
            'seconds' => 7200,
            'poster_url' => 'https://m.media-amazon.com/images/I/91NPQjJP0QL._AC_SL1500_.jpg',
            'trailer_url' => 'https://www.youtube.com/watch?v=vKQi3bBA1y8'
        ]);

        // Use the factory to create 1000 movies
        Movie::factory(1000)->create();
    }
}

<?php

namespace Database\Seeders;

use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use PHPUnit\Runner\DeprecationCollector\Collector;

class MovieSeeder extends Seeder
{
    private $timeIntervals = [];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::enableQueryLog();
        
        $this->addTimeInfo('Started');

        $movieData = $this->readMovieData();
        $genreDictionary = $this->seedGenres($movieData);
        $allMovies = $this->seedMovies($movieData);
        $this->linkMoviesToGenres($allMovies, $movieData, $genreDictionary);

        $this->showTimings();
    }

    private function showTimings()
    {
        $this->command->line("\n");
        $this->command->info('Performed: ' . count(DB::getQueryLog()) . ' queries');
        $i = count($this->timeIntervals);
        while (--$i) {
            $current = $this->timeIntervals[$i];
            $previous = $this->timeIntervals[$i - 1];
            $ms = number_format(($current['time'] - $previous['time']) * 1000);
            $this->command->info("{$current['message']}: $ms ms");
        } 
    }

    private function addTimeInfo(string $message)
    {
        $this->timeIntervals[] = [
            'time' => microtime(true),
            'message' => $message
        ];
    }

    private function readMovieData(): Collection
    {
        $movieData = collect();

        foreach([
            1980,
            1990,
            2000,
            2010,
        ] as $year)
            $movieData = $movieData->merge($this->getYearData($this->getListUrl($year)), $movieData);

        $this->addTimeInfo('Read movie data');

        return $movieData;
    }

    private function buildMovieDataDictionary(Collection $movieData)
    {
        $dictionary = [];
        foreach($movieData as $movie)
            $dictionary[$movie['name']] = $movie;

        return $dictionary;
    }

    private function linkMoviesToGenres($movies, $movieData, $genreDictionary)
    {
        $this->command->info("Linking movies and genres");
        $linkData = collect();
        $num = 0;
        $movieDictionary = $this->buildMovieDataDictionary($movieData);

        foreach($movies as $movie)
        {
            if (++$num % 100 == 0)
                $this->command->info("Found genres for {$num} movies");

            if ($matchingItem = Arr::get($movieDictionary, $movie->name))
            {
                foreach($matchingItem['genres'] as $genre)
                {
                    $linkData->add([
                        'genre_id' => $genreDictionary[$genre]->id,
                        'movie_id' => $movie->id
                    ]);
                }
            }
        }
        $this->command->info("Writing {$linkData->count()} links");
        foreach($linkData->chunk(2000) as $linkDataChunk)
            DB::table('genre_movie')->insert($linkDataChunk->toArray());

        $this->addTimeInfo('Written movie / genre links');
    }

    private function seedMovies(Collection $movieData)
    {
        $this->command->info("Writing {$movieData->count()} movies to the DB");
        $insertDataChunks = $movieData
            ->map(fn($movie) => Arr::except($movie, ['genres', 'href']))
            ->chunk(2000);

        foreach($insertDataChunks as $chunk)
            Movie::create($chunk->toArray());

        $this->addTimeInfo('Seeded movies');

        return Movie::all();
    }    

    private function seedGenres(Collection $movieData)
    {
        $genres = $this->getGenres($movieData);
        $this->command->info("Writing {$genres->count()} genres to the DB");
        Genre::insert(
            $genres
                ->map(fn($genre) => [
                    'description' => fake()->text(),
                    'name' => $genre,
                    'image_url' => "https://picsum.photos/seed/$genre/300"
                ])
                ->toArray()
        );

        $map = [];
        foreach(Genre::all() as $genre)
            $map[$genre->name] = $genre;

        $this->addTimeInfo('Seeded genres');
     
        return $map;
    }

    private function getGenres(Collection $movieData) {
        $this->command->info("Getting genres for {$movieData->count()} movies.");
        return $movieData->pluck('genres')->flatten()->unique();
    }

    private function getListUrl($year)
    {
        return "https://raw.githubusercontent.com/prust/wikipedia-movie-data/refs/heads/master/movies-{$year}s.json";
    }

    private function getYearData(string $url): Collection
    {
        $this->command->info("Reading: $url");
        $movies = Http::get($url)->json();
        $results = collect();
        foreach($movies as $movie) {
            $info = [
                'name' => Arr::get($movie, 'title'),
                'poster_url' => Arr::get($movie, 'thumbnail'),
                'description' => Arr::get($movie, 'extract'),
                'seconds' => rand(3700, 8000),
                'genres' => Arr::get($movie, 'genres', []),
                'href' => Arr::get($movie, 'href'),
            ];

            if ($this->infoOk($info))
                $results->add($info);
        }
        return collect($results);
    }

    private function infoOk(array $info): bool
    {
        return 
            $info['name'] && 
            $info['poster_url'] && 
            $info['genres'] &&
            $info['description'] &&
            count($info['genres']) &&
            $this->nameOk($info['name']);
    }

    private function nameOk(string $name)
    {
        return !in_array($name, [
            'Bamboozled'
        ]);
    }
}

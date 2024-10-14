<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GenreController extends Controller
{
    public function index() 
    {

        $genresData = Genre::orderBy('name')->paginate();
        return Inertia::render('Genres/Index', compact('genresData'));
    }

    public function show(Genre $genre) 
    {
        // movies_count will have the total number of movies
        // related to the given genre
        $genre->loadCount('movies');


        // only load the first 5 movies
        $genre->load(['movies' => fn(Builder $query) => $query->limit(5)]);
        return Inertia::render('Genres/Show', compact('genre'));
    }
}

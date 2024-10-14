<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GenreController extends Controller
{
    public function index() 
    {

        $genres = Genre::orderBy('name')->get();
        return Inertia::render('Genres/Index', compact('genres'));
    }

    public function show(Genre $genre) 
    {
        return Inertia::render('Genres/Show', compact('genre'));
    }
}

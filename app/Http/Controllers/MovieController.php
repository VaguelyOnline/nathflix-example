<?php

namespace App\Http\Controllers;

use Symfony\Component\DomCrawler\Crawler;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Inertia\Inertia;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchInput = $request->input('search');
        $paginator = Movie::where('name', 'like', "%$searchInput%")->paginate(50);     

        $featuredMovie = Movie::inRandomOrder()->first();

        return Inertia::render('Movies/Index', compact(
            'featuredMovie', 
            'paginator', 
            'searchInput'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Movie $movie, Request $request)
    {
        $movie->load('genres');
        return Inertia::render('Movies/MovieShow', compact('movie'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Movie $movie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Movie $movie)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movie $movie)
    {
        $movie->delete();
        return to_route('movies.index');
    }

    public function trailer(Movie $movie)
    {
        $urls = $this->scrapeYouTube($movie->name . ' movie trailer');
        return redirect($urls[0]);
    }

    private function getYoutubeUrls($html)
    {
        $token = '/watch?v=';
        $urls = [];
        $offset = 0;
        while (true) {
            $start = strpos($html, $token, $offset) + strlen($token);
            $end = strpos($html, '\u', $start);

            if (!$start || !$end)
                break;

            $str = substr($html, $start, $end - $start);
            $urls[] = 'https://www.youtube.com/embed/' . $str;
            $offset = $end;

            if (count($urls) > 3)
                break;
        }

        return $urls;
    }

    public function scrapeYouTube($query)
    {
        // Encode the search query for URL
        $query = urlencode($query);
        
        // URL of the YouTube search page
        $url = "https://www.youtube.com/results?search_query={$query}";
        
        // Make the request
        $response = Http::get($url);
        
        // Get the HTML response body
        $html = $response->body();

        return $this->getYoutubeUrls($html);
    }
}

<?php

use App\Http\Controllers\GenreController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// See: https://laravel.com/docs/11.x/controllers#resource-controllers
Route::resource('genres', GenreController::class);

Route::resource('movies', MovieController::class)->except([
    'edit',
    'update',
    'delete',
]);


Route::get('/movies/{movie}/trailer', [MovieController::class, 'trailer'])
    ->name('movies.trailer');

Route::get('/home', function () {
    return Inertia::render('Home');
});

Route::get('/', function (Request $request) {
    return to_route('movies.index');
});










Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::resource('movies', MovieController::class)->only([
        'edit',
        'update',
        'delete'
    ]);
});

require __DIR__.'/auth.php';

// To share screen:
// https://app.calibrae.com/alacrity

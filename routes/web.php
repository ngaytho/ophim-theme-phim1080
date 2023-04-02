<?php

use Illuminate\Support\Facades\Route;
use Ophim\ThemeFfast\Controllers\ThemeFfastController;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
    ),
], function () {
    Route::get('/', [ThemeFfastController::class, 'index']);

    Route::get('/danh-sach/hom-nay-xem-gi', function () {
        return redirect()->route('random.movies.index');
    });
    Route::get('/hom-nay-xem-gi', [ThemeFfastController::class, 'getMovieOfRandom'])->name('random.movies.index');

    Route::get(sprintf('/%s/{category}', config('ophim.routes.category', 'the-loai')), [ThemeFfastController::class, 'getMovieOfCategory'])->name('categories.movies.index');
    Route::get(sprintf('/%s/{actor}', config('ophim.routes.actors', 'dien-vien')), [ThemeFfastController::class, 'getMovieOfActor'])->name('actors.movies.index');
    Route::get(sprintf('/%s/{director}', config('ophim.routes.directors', 'dao-dien')), [ThemeFfastController::class, 'getMovieOfDirector'])->name('directors.movies.index');
    Route::get(sprintf('/%s/{tag}', config('ophim.routes.tags', 'tu-khoa')), [ThemeFfastController::class, 'getMovieOfTag'])->name('tags.movies.index');
    Route::get(sprintf('/%s/{region}', config('ophim.routes.region', 'quoc-gia')), [ThemeFfastController::class, 'getMovieOfRegion'])->name('regions.movies.index');
    Route::get(sprintf('/%s/{type}', config('ophim.routes.types', 'danh-sach')), [ThemeFfastController::class, 'getMovieOfType'])->name('types.movies.index');
    Route::get(sprintf('/%s/{movie}', config('ophim.routes.movie', 'xem-phim')), [ThemeFfastController::class, 'getMovieOverview'])->name('movies.show');
    Route::get(sprintf('/%s/{movie}/{episode}-{id}', config('ophim.routes.movie', 'xem-phim')), [ThemeFfastController::class, 'getEpisode'])
        ->where(['movie' => '.+', 'episode' => '.+', 'id' => '[0-9]+'])->name('episodes.show');
    Route::post(sprintf('/%s/{movie}/{episode}-{id}/report', config('ophim.routes.movie', 'xem-phim')), [ThemeFfastController::class, 'reportEpisode'])
        ->where(['movie' => '.+', 'episode' => '.+', 'id' => '[0-9]+'])->name('episodes.report');
    Route::post(sprintf('/%s/{movie}/rate', config('ophim.routes.movie', 'xem-phim')), [ThemeFfastController::class, 'rateMovie'])->name('movie.rating');
});

<?php


use App\Http\Controllers\CinemasController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();

Route::middleware(['web', 'auth'])->group(function () {
    Route::middleware(['admin'])->group( function () {
        Route::get('/', [ CinemasController::class, 'index' ]);
        Route::resources([
            'cinemas' => CinemasController::class,
            'halls' => \App\Http\Controllers\HallsController::class,
            'movies' => \App\Http\Controllers\MoviesController::class,
            'sessions' => \App\Http\Controllers\SessionsController::class
        ]);
    });
});

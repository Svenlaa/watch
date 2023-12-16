<?php

use App\Http\Controllers\ActorController;
use App\Http\Controllers\ActorLinkController;
use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function (Request $request) {
    if (Auth::check()) {
        return to_route('home');
    }

    return to_route('welcome');
});

Route::get('/welcome', function (Request $request) {
    return view('welcome');
})->name('welcome');

// Authed Routes
Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/home', fn () => view('dashboard'))->name('home');

    Route::group([], function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    Route::group(['as' => 'actor', 'prefix' => '/actors', 'controller' => ActorController::class], function () {
        Route::get('/', 'index');
        Route::get('/{actor}', 'show')->name('.show');
        Route::post('/create', 'create')->name('.create');

        Route::group(['as' => '.links', 'prefix' => '/{actor}/links', 'controller' => ActorLinkController::class], function () {
            Route::post('/', [ActorLinkController::class, 'store'])->name('.store');
        });
    });
});

require __DIR__.'/auth.php';

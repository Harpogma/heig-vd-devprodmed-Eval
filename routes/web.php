<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CharacterSelectionController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\MoveController;
use App\Http\Controllers\MyProfileController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TokenController;
use App\Models\Move;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $moves = Move::orderBy('created_at', 'desc')->with('user')->with('likes')->limit(3)->get();

    return view('home', ['moves' => $moves]);
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/@{username}', [ProfileController::class, 'show'])->where('username', '[A-Za-z0-9-_]+');

Route::resource('moves', MoveController::class)->except(['index', 'show'])->middleware('auth');
Route::resource('moves', MoveController::class)->only(['index', 'show']);

Route::singleton('my-profile', MyProfileController::class)->destroyable()->middleware(['auth', 'character.selected']);

Route::middleware('auth')->group(function () {
    Route::get('/character/select', [CharacterSelectionController::class, 'show'])->name('character.select');
    Route::post('/character/select', [CharacterSelectionController::class, 'store'])->name('character.store');
});

Route::match(['put', 'patch'], '/likes/{move}', [LikeController::class, 'update'])->middleware('auth');

Route::controller(AuthController::class)->group(function () {
    Route::get('/auth/register', 'showRegister');
    Route::post('/auth/register', 'register');
    Route::get('/auth/login', 'showLogin')->name('login');
    Route::post('/auth/login', 'login');
    Route::post('/auth/logout', 'logout')->middleware('auth');
});

Route::resource('tokens', TokenController::class)->only(['index', 'create', 'store', 'destroy'])->middleware('auth');

<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\SessionController;
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
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/lastmovies', [HomeController::class, 'lastMovies'])->name('lastDays');
Route::get('/nextmovies', [HomeController::class, 'nextMovies'])->name('nextDays');

Route::post('/auth', [AuthenticationController::class, 'logIn'])->name('auth');
Route::get('/logout', [AuthenticationController::class, 'logout'])->name('logout');

Route::get('/description/{id}', [RouteController::class, 'description'])->name('description');
Route::get('/auth', [RouteController::class, 'adminAuth'])->name('login');
Route::get('/admin', [RouteController::class, 'adminPage'])->name('adminPage')->middleware('auth');
Route::post('/search', [RouteController::class, 'search'])->name('search');

Route::post('/movie', [MovieController::class, 'store'])->name('storeMovie');
Route::delete('/movie/{id}', [MovieController::class, 'destroy'])->name('destroyMovie')->middleware('auth');;
Route::get('/movie/{id}', [MovieController::class, 'updateMoviePage'])->name('updateMoviePage')->middleware('auth');
Route::put('/movie/{id}', [MovieController::class, 'update'])->name('updateMovie')->middleware('auth');;

Route::post('/admin', [SessionController::class, 'store'])->name('storeSession');
Route::delete('/session/{id}', [SessionController::class, 'destroy'])->name('destroySession')->middleware('auth');;
Route::get('/session/{id}', [SessionController::class, 'updateSessionPage'])->name('updateSessionPage')->middleware('auth');
Route::put('/session/{id}', [SessionController::class, 'update'])->name('updateSession')->middleware('auth');
Route::post('/searchTable', [SessionController::class, 'searchTable'])->name('searchTable');

Route::post('/room', [RoomController::class, 'store'])->name('storeRoom');
Route::delete('/room/{id}', [RoomController::class, 'destroy'])->name('destroyRoom')->middleware('auth');
Route::put('/room/{id}', [RoomController::class, 'update'])->name('updateRoom')->middleware('auth');







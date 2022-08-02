<?php

use App\Http\Controllers\Authentication as ControllersAuthentication;
use App\Http\Controllers\Movie as ControllersMovie;
use App\Http\Controllers\Route as ControllersRoute;
use App\Http\Controllers\Home as ControllersHome;
use App\Http\Controllers\Room as ControllersRoom;
use App\Http\Controllers\Session as ControllersSession;
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

Route::get('/', [ControllersHome::class, 'index'])->name('home');
Route::get('/description/{id}', [ControllersRoute::class, 'description'])->name('description');
Route::get('/auth', [ControllersRoute::class, 'adminAuth'])->name('login');
Route::post('/auth', [ControllersAuthentication::class, 'logIn'])->name('auth');
Route::get('/admin', [ControllersRoute::class, 'adminPage'])->name('adminPage')->middleware('auth');
Route::post('/movie', [ControllersMovie::class, 'store'])->name('storeMovie');
Route::post('/room', [ControllersRoom::class, 'store'])->name(('storeRoom'));
Route::post('/admin', [ControllersSession::class, 'store'])->name('storeSession')->middleware('auth');

Route::delete('/session/{id}', [ControllersSession::class, 'destroy'])->name('destroySession');
Route::delete('/room/{id}', [ControllersRoom::class, 'destroy'])->name('destroyRoom');
Route::delete('/movie/{id}', [ControllersMovie::class, 'destroy'])->name('destroyMovie');

Route::get('/movie/{id}', [ControllersMovie::class, 'updateMoviePage'])->name('updateMoviePage')->middleware('auth');
Route::put('/movie/{id}', [ControllersMovie::class, 'update'])->name('updateMovie');

Route::get('/session/{id}', [ControllersSession::class, 'updateSessionPage'])->name('updateSessionPage')->middleware('auth');
Route::put('/session/{id}', [ControllersSession::class, 'update'])->name('updateSession');

Route::post('/search', [ControllersRoute::class, 'search'])->name('search');

Route::get('/logout', [ControllersAuthentication::class, 'logout'])->name('logout');

Route::get('/lastmovies', [ControllersHome::class, 'lastMovies'])->name('lastDays');
Route::get('/nextmovies', [ControllersHome::class, 'nextMovies'])->name('nextDays');
<?php

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\FacebookController;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});
Route::get('facebook-login',[ FacebookController::class , 'provider'])->name('facebook.login');
Route::get('facebook-callback',[ FacebookController::class , 'handleCallback'])->name('facebook.callback');

Route::get('/dashboard', function (Request $request) {
    $users = Cache::remember('users', 60, function() use($request) {
        return User::all();
    });
    // return $users;
    Cache::store('redis')->put('bar', 'baz', 600); // 10 Minutes
    
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';


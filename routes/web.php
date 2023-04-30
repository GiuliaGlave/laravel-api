<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\TypeController;
use App\Http\Controllers\Admin\TechnologyController;
use App\Http\Controllers\Guest\HomeController as GuestHomeController;
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

Route::get('/', [GuestHomeController::class, 'index'])->name('guest');
/* Route::middleware('auth')
->prefix('guest')
->name('guest.')
->group(function(){
    Route::resource('projects', ProjectController::class)
        ->parameters(['projects' => 'project:slug']);
}); */

Route::get('/dashboard', [GuestHomeController::class, 'index'])
->middleware('auth')->name('dashboard');

Route::middleware('auth')
->prefix('admin')
->name('admin.')
->group(function(){
    Route::resource('projects', ProjectController::class)
    /* ->parameters(['projects' => 'project:slug'])  */;
    Route::resource('types', TypeController::class);
    Route::resource('technologies', TechnologyController::class);
});

Route::middleware('auth')
->prefix('profile')
->name('profile.')
->group(function () {
    Route::get('/', [ProfileController::class, 'edit'])->name('edit');
    Route::patch('/', [ProfileController::class, 'update'])->name('update');
    Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
});

require __DIR__.'/auth.php';
<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\MenusController;
use App\Http\Controllers\SummariesController;
use App\Http\Controllers\DashboardController;


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
    return view('welcome');
});

Route::get('/dashboard', function () {
    date_default_timezone_set('Asia/Yakutsk');
    $date = date('Y-m-d');
    if(Auth::user()->type < 3){
        return redirect('/menus');
    }
    else{
        return redirect()->route('summaries.show', ['date' => $date]);
    }
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::prefix('/menus')->group(function () {
        Route::controller(MenusController::class)->group(function () {
            Route::get('/', 'show')->name('menus.show');
            Route::post('/add', 'add')->name('menus.add');
            Route::post('/registration', 'registration')->name('menus.registration');
        });
    });
    Route::prefix('/summary')->group(function () {
        Route::controller(SummariesController::class)->group(function () {
            Route::get('/{date}', 'show')->name('summaries.show');
            Route::post('/confirm', 'confirm')->name('summary.confirm');
        });
    });
});

require __DIR__.'/auth.php';

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DomainController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\HomeController;

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

Route::get('/', function () {
    if(Auth::check()){
        return redirect()->route('home');
    }else{
        return redirect()->route('login');
    }
});

Auth::routes();
Route::middleware(['auth'])->get('/home', [DomainController::class, 'index'])->name('home');
    // make a route for domain create
    Route::group(['middleware' => ['auth'], 'prefix' => 'domain', 'as' => 'domain.'], function () {
            Route::get('/home/{id?}', [DomainController::class, 'index'])->name('home');
            Route::post('store', [DomainController::class, 'store'])->name('store');
            Route::put('domain/{domain}', [DomainController::class, 'update'])->name('update');
            Route::delete('domain/{domain}', [DomainController::class, 'destroy'])->name('destroy');
});





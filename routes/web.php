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
        return redirect()->route('dashboard');
    }else{
        return redirect()->route('login');
    }
});
Auth::routes();
Route::middleware(['auth'])->get('/dashboard', [DomainController::class, 'index'])->name('dashboard');
Route::get('/home', [DomainController::class, 'index'])->name('home');
Route::get('/domain_list', [DomainController::class, 'domain_list'])->name('domain_list');
// make a route for domain create
Route::group(['middleware' => ['auth'], 'prefix' => 'domain', 'as' => 'domain.'], function () {
    Route::get('/domain_list/{id?}', [DomainController::class, 'domain_list'])->name('domain_list');
    // Route::get('/home/{id?}', [DomainController::class, 'index'])->name('home');
    Route::post('store', [DomainController::class, 'store'])->name('store');
    Route::put('domain/{domain}', [DomainController::class, 'update'])->name('update');
    Route::post('/send-domain-mail/{id}', [DomainController::class, 'sendDomainMail'])->name('mail');
Route::delete('domain/{domain}', [DomainController::class, 'destroy'])->name('destroy');
});





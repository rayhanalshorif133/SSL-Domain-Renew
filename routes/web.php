<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DomainController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CustomAuthController;



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

Route::get('login', [CustomAuthController::class, 'index'])->name('login');
Route::get('home', [CustomAuthController::class, 'customHome'])->name('home');
Route::post('custom-login', [CustomAuthController::class, 'customLogin'])->name('login.custom');

// Route::get('registration', [CustomAuthController::class, 'registration'])->name('register-user');
Route::post('custom-registration', [CustomAuthController::class, 'customRegistration'])->name('register.custom');
Route::get('signout', [CustomAuthController::class, 'signOut'])->name('signout');

/* New Added Routes */
Route::get('dashboard', [CustomAuthController::class, 'dashboard'])->middleware(['auth']);

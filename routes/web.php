<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Vendor\DashboardController as VendorDahsboardController;
use App\Http\Controllers\Vendor\VenueController;
use App\Http\Controllers\Vendor\EventController;

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDahsboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\VenueController as AdminVenueController;

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

Auth::routes();
Route::get('/', function () { return view('home');});
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

/***********************************************************************
 *************************** Vendor Panel *******************************
 **********************************************************************/
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [VendorDahsboardController::class, 'index'])->name('dashboard');
    Route::controller(VenueController::class)->name('venue.')->prefix('venue')->as('venue.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::put('/update/{id}', 'update')->name('update');
        Route::get('/delete/{id}', 'destroy')->name('destroy');
    });
    Route::controller(EventController::class)->name('event.')->prefix('event')->as('event.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::put('/update/{id}', 'update')->name('update');
        Route::get('/delete/{id}', 'destroy')->name('destroy');
    });
});

/***********************************************************************
 *************************** Admin Panel *******************************
 **********************************************************************/
Route::name('admin.')->prefix('admin')->as('admin.')->group(function () {
    Route::controller(AdminAuthController::class)->group(function () {
        Route::get('/login', 'showLoginForm')->name('login');
        Route::post('/login', 'login')->name('login');
        Route::post('/logout', 'logout')->name('logout');
    });
    Route::middleware('auth:admin')->group(function () {
        Route::get('/', [AdminDahsboardController::class, 'index'])->name('dashboard');
        
        Route::controller(AdminUserController::class)->name('users.')->prefix('users')->as('users.')->group(function () {
            Route::get('/{role}', 'index')->name('index');
        });

        Route::controller(AdminVenueController::class)->name('venues.')->prefix('venues')->as('venues.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/featured', 'featured')->name('featured');
        });
    });
});

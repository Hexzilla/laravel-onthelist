<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

use App\Http\Controllers\Vendor\DashboardController as VendorDahsboardController;
use App\Http\Controllers\Vendor\VenueController as VendorVenueController;
use App\Http\Controllers\Vendor\EventController as VendorEventController;
use App\Http\Controllers\Vendor\BookingController as VendorBookingController;
use App\Http\Controllers\Vendor\PaymentController as VendorPaymentController;
use App\Http\Controllers\Vendor\SettingController as VendorSettingController;

use App\Http\Controllers\Dj\DashboardController as DjDashboardController;
use App\Http\Controllers\Dj\ProfileController as DjProfileController;
use App\Http\Controllers\Dj\EventController as DjEventController;

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDahsboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\VenueController as AdminVenueController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;

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
// Route::get('/login', [AuthController::class, 'index'])->name('login');
// Route::post('login', [AuthController::class, 'login'])->name('login');
// Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::name('vendors.')->prefix('vendors')->as('vendors.')->group(function () {
    Route::middleware('auth')->group(function () {
        Route::get('/', [VendorDahsboardController::class, 'index'])->name('dashboard');

        Route::controller(VendorBookingController::class)->name('booking.')->prefix('booking')->as('booking.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/approved/{id}', 'approve')->name('approve');
            Route::get('/rejected/{id}', 'reject')->name('reject');
        });

        Route::controller(VendorSettingController::class)->name('setting.')->prefix('setting')->as('setting.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/store', 'store')->name('store');
        });

        Route::controller(VendorPaymentController::class)->name('payment.')->prefix('payment')->as('payment.')->group(function () {
            Route::get('/', 'index')->name('index');
        });

        Route::controller(VendorVenueController::class)->name('venue.')->prefix('venue')->as('venue.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::put('/update/{id}', 'update')->name('update');
            Route::get('/delete/{id}', 'destroy')->name('destroy');
        });
        Route::controller(VendorEventController::class)->name('event.')->prefix('event')->as('event.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::put('/update/{id}', 'update')->name('update');
            Route::get('/delete/{id}', 'destroy')->name('destroy');
        });
    });
});

Route::name('dj.')->prefix('dj')->as('dj.')->group(function () {
    Route::middleware('auth')->group(function () {
        Route::get('/', [DjDashboardController::class, 'index'])->name('dashboard');
        Route::get('/upcoming', [DjEventController::class, 'index'])->name('event');
        
        Route::controller(DjProfileController::class)->name('profile.')->prefix('profile')->as('profile.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::put('/store', 'store')->name('store');
            Route::get('/delete/media/{id}', 'deleteMedia')->name('deletemedia');
        });
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
        
        Route::controller(AdminBookingController::class)->name('booking.')->prefix('booking')->as('booking.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/approved/{id}', 'approved')->name('approve');
        });
        
        Route::controller(AdminUserController::class)->name('users.')->prefix('users')->as('users.')->group(function () {
            Route::get('/{role}', 'index')->name('index');
            Route::get('/user/{id}', 'edit')->name('edit');
            Route::put('/update/{id}', 'update')->name('update');
            Route::get('/Djs/{id}', 'show')->name('show');
            Route::get('/approve/{id}', 'approve')->name('approve');
            Route::get('/reject/{id}', 'reject')->name('reject');
        });

        Route::controller(AdminVenueController::class)->name('venues.')->prefix('venues')->as('venues.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/featured', 'featured')->name('featured');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::get('/delete/{id}', 'destroy')->name('destroy');
            Route::put('/update/{id}', 'update')->name('update');
            Route::get('/feature/{id}', 'feature')->name('feature');
            Route::get('/approve/{id}', 'approve')->name('approve');
            Route::get('/reject/{id}', 'reject')->name('reject');
        });

        Route::controller(AdminEventController::class)->name('events.')->prefix('events')->as('events.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/upcoming', 'upcoming')->name('upcoming');
            Route::get('/featured', 'featured')->name('featured');
            Route::get('/complete', 'complete')->name('complete');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::get('/delete/{id}', 'destroy')->name('destroy');
            Route::put('/update/{id}', 'update')->name('update');
            Route::get('/feature/{id}', 'feature')->name('feature');
            Route::get('/approve/{id}', 'approve')->name('approve');
            Route::get('/reject/{id}', 'reject')->name('reject');
        });
    });
});

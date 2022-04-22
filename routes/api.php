<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Vendor\EventController;
use App\Http\Controllers\Vendor\VenueController;

use App\Http\Controllers\Api\Vendor\EventController as VendorEventController;
use App\Http\Controllers\Api\Vendor\VenueController as VendorVenueController;
use App\Http\Controllers\Api\Vendor\DjController as VendorDjController;
use App\Http\Controllers\Api\Vendor\BookingController as VendorBookingController;
use App\Http\Controllers\Api\Vendor\SettingController as VendorSettingController;

use App\Http\Controllers\Api\Admin\UserController as AdminUserController;
use App\Http\Controllers\Api\Admin\VendorController as AdminVendorController;
use App\Http\Controllers\Api\Admin\VenueController as AdminVenueController;
use App\Http\Controllers\Api\Admin\EventController as AdminEventController;
use App\Http\Controllers\Api\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Api\Admin\DjController as AdminDjController;

use App\Http\Controllers\Api\Dj\ProfileController as DjProfileController;
use App\Http\Controllers\Api\Dj\EventController as DjEventController;

use App\Http\Controllers\Api\Customer\EventController as CustomerEventController;
use App\Http\Controllers\Api\Customer\VenueController as CustomerVenueController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::controller(EventController::class)->prefix('event')->group(function(){
    Route::get('/ticket/{id}', 'getTickets');
    Route::get('/table/{id}', 'getTables');
    Route::get('/guestlist/{id}', 'getGuestlists');
});

Route::controller(VenueController::class)->prefix('venue')->group(function(){
    Route::get('/table/{id}', 'getTables');
    Route::get('/offer/{id}', 'getOffers');
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('vendor')->group(function(){
    Route::controller(VendorBookingController::class)->prefix('booking')->group(function () {
        Route::get('/', 'index');
        Route::get('/approved/{id}', 'approve');
        Route::get('/rejected/{id}', 'reject');
    });

    Route::controller(VendorDjController::class)->prefix('dj')->group(function () {
        Route::get('/', 'index');
        Route::post('/store', 'store');
        Route::get('/edit/{id}', 'edit');
        Route::put('/update/{id}', 'update');
        Route::get('/delete/{id}', 'destroy');
    });

    Route::controller(VendorVenueController::class)->prefix('venue')->group(function () {
        Route::get('/', 'index');
        Route::post('/store', 'store');
        Route::get('/edit/{id}', 'edit');
        Route::put('/update/{id}', 'update');
        Route::get('/delete/{id}', 'destroy');
        Route::get('/table/{id}', 'getTables');
        Route::get('/offer/{id}', 'getOffers');
    });

    Route::controller(VendorEventController::class)->prefix('event')->group(function () {
        Route::get('/', 'index');
        Route::get('/create', 'create');
        Route::post('/store', 'store');
        Route::get('/edit/{id}', 'edit');
        Route::put('/update/{id}', 'update');
        Route::get('/delete/{id}', 'destroy');
        Route::get('/ticket/{id}', 'getTickets');
        Route::get('/table/{id}', 'getTables');
        Route::get('/guestlist/{id}', 'getGuestlists');
    });

    Route::controller(VendorSettingController::class)->prefix('setting')->group(function () {
        Route::get('/', 'index');
        Route::post('/password', 'changePassword');
        Route::post('/contact', 'contact');
        Route::get('/close', 'closeAccount');
    });
});

Route::prefix('admin')->group(function(){
    Route::controller(AdminBookingController::class)->prefix('booking')->group(function () {
        Route::get('/', 'index');
        Route::get('/approve/{id}', 'approve');
        Route::get('/reject/{id}', 'reject');
    });
    
    Route::controller(AdminUserController::class)->prefix('users')->group(function () {
        Route::get('/', 'index');
        Route::get('/user/{id}', 'edit');
        Route::put('/update/{id}', 'update');
        Route::get('/djs/{id}', 'show');
        Route::get('/approve/{id}', 'approve');
        Route::get('/reject/{id}', 'reject');
    });

    Route::controller(AdminVendorController::class)->name('vendors.')->prefix('vendors')->as('vendors.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::put('/update/{id}', 'update')->name('update');
        Route::get('/resume/{id}', 'resume')->name('resume');
        Route::get('/pause/{id}', 'pause')->name('pause');
        Route::get('/delete/{id}', 'destroy')->name('destroy');
    });

    Route::controller(AdminDjController::class)->name('djs.')->prefix('djs')->as('djs.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::put('/update/{id}', 'update')->name('update');
        Route::get('/delete/{id}', 'destroy')->name('destroy');
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
        Route::get('/unfeature/{id}', 'unfeature')->name('unfeature');
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
        Route::get('/unfeature/{id}', 'unfeature')->name('unfeature');
        Route::get('/approve/{id}', 'approve')->name('approve');
        Route::get('/reject/{id}', 'reject')->name('reject');
    });
});

Route::prefix('dj')->group(function(){
    Route::get('/event', [DjEventController::class, 'index']);
        
    Route::controller(DjProfileController::class)->name('profile.')->prefix('profile')->as('profile.')->group(function () {
        Route::get('/', 'index');
        Route::get('/edit', 'edit');
        Route::put('/store', 'store');
        Route::get('/delete/media/{id}', 'deleteMedia');
    });
});

Route::prefix('customer')->group(function(){
    Route::controller(CustomerEventController::class)->prefix('events')->group(function () {
        Route::get('/', 'index');
        Route::get('/favorite', 'favourite');
        Route::get('/favourited/{id}', 'favourited');
        Route::get('/unfavourite/{id}', 'unfavourite');
        Route::get('/booking/{id}', 'booking');
        Route::post('/create', 'createBooking');
    });

    Route::controller(CustomerVenueController::class)->prefix('venues')->group(function () {
        Route::get('/', 'index');
        Route::get('/favorite', 'favourite');
        Route::get('/favourited/{id}', 'favourited');
        Route::get('/unfavourite/{id}', 'unfavourite');
        Route::get('/booking/{id}', 'booking');
        Route::post('/create', 'createBooking');
    });
});

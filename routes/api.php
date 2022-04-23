<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Vendor\EventController;
use App\Http\Controllers\Vendor\VenueController;

use App\Http\Controllers\Api\AuthController;

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

Route::prefix('v1')->group(function() {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);

    Route::middleware('auth:api')->group(function(){
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

    Route::controller(AdminVendorController::class)->prefix('vendors')->group(function () {
        Route::get('/', 'index');
        Route::get('/edit/{id}', 'edit');
        Route::put('/update/{id}', 'update');
        Route::get('/resume/{id}', 'resume');
        Route::get('/pause/{id}', 'pause');
        Route::get('/delete/{id}', 'destroy');
    });

    Route::controller(AdminDjController::class)->prefix('djs')->group(function () {
        Route::get('/', 'index');
        Route::post('/store', 'store');
        Route::get('/edit/{id}', 'edit');
        Route::put('/update/{id}', 'update');
        Route::delete('/delete/{id}', 'destroy');
        Route::get('/approve/{id}', 'approve');
        Route::get('/reject/{id}', 'reject');
    });

    Route::controller(AdminVenueController::class)->prefix('venues')->group(function () {
        Route::get('/', 'index');
        Route::get('/featured', 'featured');
        Route::get('/edit/{id}', 'edit');
        Route::delete('/delete/{id}', 'destroy');
        Route::put('/update/{id}', 'update');
        Route::get('/feature/{id}', 'feature');
        Route::get('/unfeature/{id}', 'unfeature');
        Route::get('/approve/{id}', 'approve');
        Route::get('/reject/{id}', 'reject');
    });

    Route::controller(AdminEventController::class)->prefix('events')->group(function () {
        Route::get('/', 'index');
        Route::get('/upcoming', 'upcoming');
        Route::get('/featured', 'featured');
        Route::get('/complete', 'complete');
        Route::get('/edit/{id}', 'edit');
        Route::delete('/delete/{id}', 'destroy');
        Route::put('/update/{id}', 'update');
        Route::get('/feature/{id}', 'feature');
        Route::get('/unfeature/{id}', 'unfeature');
        Route::get('/approve/{id}', 'approve');
        Route::get('/reject/{id}', 'reject');
    });
});



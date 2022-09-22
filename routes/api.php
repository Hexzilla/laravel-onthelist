<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Vendor\EventController;
use App\Http\Controllers\Vendor\VenueController;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\Auth\GoogleLoginController;
use App\Http\Controllers\Api\Auth\AppleLoginController;

use App\Http\Controllers\Api\SettingController as SettingController;
use App\Http\Controllers\Api\SubscriptionController;
use App\Http\Controllers\Api\NotificationController as NotificationController;
use App\Http\Controllers\Api\FollowingController as FollowingController;
use App\Http\Controllers\Api\PlanController as PlanController;

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
use App\Http\Controllers\Api\Admin\PushNotificationController as PushNotificationController;

use App\Http\Controllers\Api\Dj\ProfileController as DjProfileController;
use App\Http\Controllers\Api\Dj\EventController as DjEventController;

use App\Http\Controllers\Api\Customer\EventController as CustomerEventController;
use App\Http\Controllers\Api\Customer\VenueController as CustomerVenueController;
use App\Http\Controllers\Api\Customer\DjController as CustomerDjController;
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

Route::prefix('v1')->group(function() {
    Route::post('/auth/register', [AuthController::class, 'register']);
    Route::post('/auth/login', [AuthController::class, 'login']);

    Route::get('/auth/google', [GoogleLoginController::class, 'redirectToGoogle']);
    Route::get('/auth/google/callback', [GoogleLoginController::class, 'handleGoogleCallback']);

    Route::post('/auth/apple', [AppleLoginController::class, 'appleLogin']);

    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::get('/me', function(Request $request) {
            return auth()->user();
        });
    
        Route::post('/auth/logout', [AuthController::class, 'logout']);

        Route::prefix('subscription')->group(function() {
            Route::post('/purchase', [SubscriptionController::class, 'purchase']);
        });

        Route::prefix('settings')->group(function() {
            Route::post('/account/change_password', [SettingController::class, 'changePassword']);
            Route::post('/account/close', [SettingController::class, 'closeAccount']);
        });

        Route::prefix('notifications')->group(function() {
            Route::get('/', [NotificationController::class, 'index']);
            Route::get('/unread', [NotificationController::class, 'unread']);
            Route::get('/read/{id}', [NotificationController::class, 'markAsRead']);
        });

        Route::prefix('following')->group(function() {
            Route::get('/', [FollowingController::class, 'index']);
            Route::post('/add/{following_user_id}', [FollowingController::class, 'add_following']);
            Route::delete('/remove/{following_user_id}', [FollowingController::class, 'remove_following']);
        });

        Route::prefix('plan')->group(function() {
            Route::get('/', [PlanController::class, 'index']);
            Route::post('/add', [PlanController::class, 'add_plan']);
            Route::delete('/remove/{id}', [PlanController::class, 'remove_plan']);
        });

        Route::prefix('vendor')->group(function(){
            Route::controller(VendorBookingController::class)->prefix('booking')->group(function () {
                Route::get('/', 'index');
                Route::get('/approve/{id}', 'approve');
                Route::get('/reject/{id}', 'reject');
            });
        
            Route::controller(VendorDjController::class)->prefix('dj')->group(function () {
                Route::get('/', 'index');
                Route::post('/store', 'store');
                Route::get('/edit/{id}', 'edit');
                Route::put('/update/{id}', 'update');
                Route::delete('/delete/{id}', 'destroy');
                Route::get('/message/{id}', 'showMessage');
                Route::get('/mark/{id}', 'markAsRead');
            });
        
            Route::controller(VendorVenueController::class)->prefix('venue')->group(function () {
                Route::get('/', 'index');
                Route::post('/store', 'store');
                Route::get('/edit/{id}', 'edit');
                Route::put('/update/{id}', 'update');
                Route::delete('/delete/{id}', 'destroy');
                Route::get('/table/{id}', 'getTables');
                Route::get('/offer/{id}', 'getOffers');
                Route::get('/message/{id}', 'showMessage');
                Route::get('/mark/{id}', 'markAsRead');
                Route::get('/{id}', 'filterCity')->name('filter');
            });
        
            Route::controller(VendorEventController::class)->prefix('event')->group(function () {
                Route::get('/', 'index');
                Route::get('/create', 'create');
                Route::post('/store', 'store');
                Route::get('/edit/{id}', 'edit');
                Route::put('/update/{id}', 'update');
                Route::delete('/delete/{id}', 'destroy');
                Route::get('/ticket/{id}', 'getTickets');
                Route::get('/table/{id}', 'getTables');
                Route::get('/guestlist/{id}', 'getGuestlists');
                Route::get('/message/{id}', 'showMessage');
                Route::get('/mark/{id}', 'markAsRead');
                Route::get('/{id}', 'filterCity')->name('filter');
            });
        
            Route::controller(VendorSettingController::class)->prefix('setting')->group(function () {
                Route::get('/', 'index');
                Route::put('/password', 'changePassword');
                Route::post('/contact', 'contact');
                Route::get('/close', 'closeAccount');
            });
        });

        Route::prefix('dj')->group(function(){
            Route::get('/event', [DjEventController::class, 'index']);
                
            Route::controller(DjProfileController::class)->name('profile.')->prefix('profile')->as('profile.')->group(function () {
                Route::get('/', 'index');
                Route::get('/edit', 'edit');
                Route::put('/update', 'store');
                Route::delete('/delete/media/{id}', 'deleteMedia');
                Route::get('/message/{id}', 'showMessage');
                Route::get('/mark/{id}', 'markAsRead');
            });
        });
        
        Route::prefix('customer')->group(function(){
            Route::controller(CustomerEventController::class)->prefix('events')->group(function () {
                Route::get('/', 'index');
                Route::get('/favorite', 'favorites');
                Route::get('/like/{id}', 'add_favorite');
                Route::get('/unlike/{id}', 'remove_favorite');
                Route::get('/{id}', 'event');
                Route::post('/create', 'createBooking');
                Route::get('/booking/{id}', 'booking');
                Route::get('/listByDate', 'filter_date');
                Route::post('/message', 'createMessage');
                Route::post('/purchase', 'purchase');
                Route::get('/city/{id}', 'filterCity');
                Route::post('/check', 'ticket');
            });
        
            Route::controller(CustomerVenueController::class)->prefix('venues')->group(function () {
                Route::get('/', 'index');
                Route::get('/favorite', 'favorites');
                Route::get('/like/{id}', 'add_favorite');
                Route::get('/unlike/{id}', 'remove_favorite');
                Route::get('/{id}', 'venue');
                Route::get('/booking/{id}', 'booking');
                Route::post('/check', 'ticket');
                Route::post('/create', 'createBooking');
                Route::post('/message', 'createMessage');
                Route::post('/purchase', 'purchase');
                Route::get('/city/{id}', 'filterCity');
            });

            Route::controller(CustomerCardController::class)->prefix('cards')->group(function () {
                Route::get('/card', 'showCard');
                Route::get('/{id}', 'showAccount');
                Route::post('/add', 'addCard');
            });

            Route::controller(CustomerDjController::class)->prefix('djs')->group(function () {
                Route::get('/', 'index');
                Route::get('/{id}', 'get');
                Route::get('/favorite', 'favourites');
                Route::get('/like/{id}', 'add_favorite');
                Route::get('/unlike/{id}', 'remove_favorite');
                Route::post('/message', 'createMessage');
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
        Route::get('/{id}', 'filterCity')->name('filter');
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
        Route::get('/{id}', 'filterCity')->name('filter');
    });

    Route::controller(PushNotificationController::class)->prefix('notification')->group(function () {
        Route::get('/link', 'getLink');
        Route::post('/notify', 'pushNotification');
    });
});



<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SettingController as SettingController;
use App\Http\Controllers\SubscriptionController;

use App\Http\Controllers\Vendor\DashboardController as VendorDahsboardController;
use App\Http\Controllers\Vendor\DjController as VendorDjController;
use App\Http\Controllers\Vendor\VenueController as VendorVenueController;
use App\Http\Controllers\Vendor\EventController as VendorEventController;
use App\Http\Controllers\Vendor\BookingController as VendorBookingController;
use App\Http\Controllers\Vendor\PaymentController as VendorPaymentController;
use App\Http\Controllers\Vendor\SettingController as VendorSettingController;

use App\Http\Controllers\Dj\DashboardController as DjDashboardController;
use App\Http\Controllers\Dj\ProfileController as DjProfileController;
use App\Http\Controllers\Dj\EventController as DjEventController;

use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\Customer\EventController as CustomerEventController;
use App\Http\Controllers\Customer\VenueController as CustomerVenueController;

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDahsboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\VendorController as AdminVendorController;
use App\Http\Controllers\Admin\VenueController as AdminVenueController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\DjController as AdminDjController;
use App\Http\Controllers\Admin\NotificationController as AdminNotificationController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;

use App\Http\Controllers\Auth\GoogleLoginController;
use App\Http\Controllers\Auth\AppleLoginController;

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
Route::get('/auth/google', [GoogleLoginController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [GoogleLoginController::class, 'handleGoogleCallback']);
Route::post('/auth/apple', [AppleLoginController::class, 'appleLogin']);

/***********************************************************************/
Route::name('subscription.')->prefix('subscription')->as('subscription.')->group(function () {
    Route::middleware('auth')->group(function () {
        Route::get('/create', [SubscriptionController::class, 'index'])->name('create');
        Route::post('/purchase', [SubscriptionController::class, 'purchase'])->name('purchase');
    });
});
/***********************************************************************
 *************************** Vendor Panel *******************************
 **********************************************************************/
Route::name('vendors.')->prefix('vendors')->as('vendors.')->group(function () {
    Route::middleware('auth')->group(function () {
        Route::get('/', [VendorDahsboardController::class, 'index'])->name('dashboard');
        Route::get('/reps', [VendorEventController::class, 'reps'])->name('reps');

        Route::controller(VendorBookingController::class)->name('booking.')->prefix('booking')->as('booking.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/approved/{id}', 'approve')->name('approve');
            Route::get('/rejected/{id}', 'reject')->name('reject');
        });

        Route::controller(VendorPaymentController::class)->name('payment.')->prefix('payment')->as('payment.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/store', 'store')->name('store');
            Route::get('/venue/{id}', 'venue')->name('venue');
            Route::post('/vstore/{id}', 'storeVenue')->name('storevenue');
        });

        Route::controller(VendorDjController::class)->name('dj.')->prefix('dj')->as('dj.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::put('/update/{id}', 'update')->name('update');
            Route::get('/delete/{id}', 'destroy')->name('destroy');
        });

        Route::controller(VendorVenueController::class)->name('venue.')->prefix('venue')->as('venue.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::put('/update/{id}', 'update')->name('update');
            Route::get('/delete/{id}', 'destroy')->name('destroy');
            Route::get('/{id}', 'filterCity')->name('filter');
        });

        Route::controller(VendorEventController::class)->name('event.')->prefix('events')->as('event.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::put('/update/{id}', 'update')->name('update');
            Route::get('/delete/{id}', 'destroy')->name('destroy');
            Route::get('/{id}', 'filterCity')->name('filter');
            Route::get('/addrep/{id}', 'createRep')->name('createRep');
            Route::post('/storerep', 'storeRep')->name('storeRep');
            Route::post('/scanbooking', 'scanBooking')->name('scanbooking');
        });

        Route::controller(VendorSettingController::class)->name('setting.')->prefix('setting')->as('setting.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/profile', 'profile')->name('profile');
            Route::post('/password', 'changePassword')->name('password');
            Route::post('/contact', 'contact')->name('contact');
            Route::get('/close', 'closeAccount')->name('close');
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

Route::name('customers.')->prefix('customers')->as('customers.')->group(function () {
    Route::middleware('auth')->group(function () {
        Route::get('/', [CustomerDashboardController::class, 'index'])->name('dashboard');
        
        Route::controller(CustomerEventController::class)->name('events.')->prefix('events')->as('events.')->group(function () {
            Route::get('/all', 'index')->name('index');
            Route::get('/favorite', 'favourite')->name('favorite');
            Route::get('/favourited/{id}', 'favourited')->name('favourited');
            Route::get('/unfavourite/{id}', 'unfavourite')->name('unfavourite');
            Route::get('/booking/{id}', 'booking')->name('booking');
            Route::post('/create', 'createBooking')->name('createBooking');
            Route::get('/rep', 'rep')->name('createRep');
            Route::post('/storerep', 'storeRep')->name('storeRep');
        });

        Route::controller(CustomerVenueController::class)->name('venues.')->prefix('venues')->as('venues.')->group(function () {
            Route::get('/all', 'index')->name('index');
            Route::get('/favorite', 'favourite')->name('favorite');
            Route::get('/favourited/{id}', 'favourited')->name('favourited');
            Route::get('/unfavourite/{id}', 'unfavourite')->name('unfavourite');
            Route::get('/booking/{id}', 'booking')->name('booking');
            Route::post('/create', 'createBooking')->name('createBooking');
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
        Route::get('/inbox', [AdminDahsboardController::class, 'inbox'])->name('inbox');
        
        Route::controller(AdminBookingController::class)->name('booking.')->prefix('booking')->as('booking.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/approve/{id}', 'approve')->name('approve');
            Route::get('/reject/{id}', 'reject')->name('reject');
        });
        
        Route::controller(AdminUserController::class)->name('users.')->prefix('users')->as('users.')->group(function () {
            Route::get('/{role}', 'index')->name('index');
            Route::get('/user/{id}', 'edit')->name('edit');
            Route::put('/update/{id}', 'update')->name('update');
            Route::get('/Djs/{id}', 'show')->name('show');
            Route::get('/approve/{id}', 'approve')->name('approve');
            Route::get('/reject/{id}', 'reject')->name('reject');
            Route::get('/delete/{id}', 'destroy')->name('destroy');
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
            Route::get('/all', 'index')->name('index');
            Route::get('/featured', 'featured')->name('featured');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::get('/delete/{id}', 'destroy')->name('destroy');
            Route::put('/update/{id}', 'update')->name('update');
            Route::get('/feature/{id}', 'feature')->name('feature');
            Route::get('/unfeature/{id}', 'unfeature')->name('unfeature');
            Route::get('/approve/{id}', 'approve')->name('approve');
            Route::get('/reject/{id}', 'reject')->name('reject');
            Route::get('/city', 'addCity')->name('city');
            Route::post('/city', 'storeCity')->name('store');
            Route::get('/{id}', 'filterCity')->name('filter');
            Route::get('/upload/{id}','upload')->name('upload');
            Route::post('/upload/{id}', 'uploadImage')->name('uploadImage');
        });

        Route::controller(AdminEventController::class)->name('events.')->prefix('events')->as('events.')->group(function () {
            Route::get('/all', 'index')->name('index');
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
            Route::get('/{id}', 'filterCity')->name('filter');
            Route::get('/upload/{id}','upload')->name('upload');
            Route::post('/upload/{id}', 'uploadImage')->name('uploadImage');
        });

        Route::controller(AdminPaymentController::class)->name('payments.')->prefix('payments')->as('payments.')->group(function() {
            Route::get('/details', 'vendor')->name('vendor');
        });

        Route::controller(AdminNotificationController::class)->name('notifications.')->prefix('notifications')->as('notifications.')->group(function() {
            Route::get('/', 'index')->name('index');
            Route::get('/unread', 'unread')->name('unread');
            Route::get('/read/{id}', 'markAsRead')->name('markAsRead');
            Route::get('/push', 'getLink')->name('create');
            Route::post('/push', 'pushNotification')->name('push');
        });

        Route::controller(AdminSettingController::class)->name('setting.')->prefix('setting')->as('setting.')->group(function() {
            Route::get('/', 'index')->name('index');
            Route::post('/change', 'change')->name('password');
            Route::get('/profile', 'profile')->name('profile');
        });
    });
});

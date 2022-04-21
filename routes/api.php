<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Vendor\EventController as VendorEventController;
use App\Http\Controllers\Vendor\VenueController as VendorVenueController;
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
Route::controller(VendorEventController::class)->name('event.')->prefix('event')->as('event.')->group(function(){
    Route::post('/ticket/{id}', 'getTickets');
    Route::post('/table/{id}', 'getTables');
    Route::post('/guestlist/{id}', 'getGuestlists');
});

Route::controller(VendorVenueController::class)->name('venue.')->prefix('venue')->as('venue.')->group(function(){
    Route::post('/table/{id}', 'getTables');
    Route::post('/offer/{id}', 'getOffers');
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

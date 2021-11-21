<?php

use App\Http\Controllers\AirlineController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\FlightBookController;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\NewPasswordController;
use App\Http\Controllers\ProcessFlightController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//----- Authentication without bearer -----//

Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/forgot-password', [NewPasswordController::class, 'forgotPassword'])->name('auth.forgotPassword');
Route::post('/reset-password', [NewPasswordController::class, 'reset'])->name('auth.resetPassword');

//----- Authentication without verified -----//

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::post('/email/verification-notification', [EmailVerificationController::class, 'sendVerificationEmail'])->name('verification.resend');
    Route::get('/verify-email/{id}/{hash}', [EmailVerificationController::class, 'verify'])->name('verification.verify');
});

//----- Verified Authentication -----//

Route::middleware(['auth', 'verified'])->group(function () {

    //--- Airline ---//
    Route::get('/airline', [AirlineController::class, 'index'])->name('airline.index');
    Route::get('/airline/{airline}', [AirlineController::class, 'show'])->name('airline.show');

    //--- Flight ---//
    Route::get('/flight', [FlightController::class, 'index'])->name('flight.index');
    Route::get('/flight/{flight}', [FlightController::class, 'show'])->name('flight.show');

    //--- FlightBook ---//
    Route::get('flight-book/all/{flight}', [FlightBookController::class, 'flightId'])->name('flightBook.allFlight');
    Route::get('flight-book/my-flight', [FlightBookController::class, 'myFlightBooks'])->name('flightBook.myFlight');
    Route::get('flight-book/{flightBook}/', [FlightBookController::class, 'show'])->name('flightBook.show');
    Route::post('flight-book/', [FlightBookController::class, 'store'])->name('flightBook.store');
    Route::put('flight-book/refund/{flightBook}', [ProcessFlightController::class, 'refund'])->name('flightBook.refund');

    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});

//----- Authentication is Admin -----//

Route::middleware(['auth', 'admin'])->group(function () {
    
    //--- Airline ---//
    Route::post('/airline', [AirlineController::class, 'store'])->name('airline.store');
    Route::put('/airline/{airline}', [AirlineController::class, 'update'])->name('airline.update');
    Route::patch('/airline/{airline}', [AirlineController::class, 'update'])->name('airline.update');
    Route::delete('/airline/{airline}', [AirlineController::class,'destroy'])->name('airline.destroy');

    //--- Flight ---//
    Route::post('/flight', [FlightController::class, 'store'])->name('flight.store');
    Route::put('/flight/{flight}', [FlightController::class, 'update'])->name('flight.update');
    Route::patch('/flight/{flight}', [FlightController::class, 'update'])->name('flight.update');
    Route::delete('/flight/{flight}', [FlightController::class,'destroy'])->name('flight.destroy');

});

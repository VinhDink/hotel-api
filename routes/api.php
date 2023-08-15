<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CheckinController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth')->group(function () {
    Route::prefix('userlist')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('userList');
        Route::delete('/del', [UserController::class, 'destroy'])->name('userDestroy');
    });

    Route::prefix('checked')->group(function () {
        Route::post('/', [BookingController::class, 'checkin'])->name('checked');
        Route::post('/checkout', [CheckinController::class, 'checkout'])->name('checkout');
        Route::post('/addFee', [CheckinController::class, 'updateFee'])->name('addFee');
    });

    Route::prefix('profile')->group(function () {
        Route::get('/amount/{id}', [BookingController::class, 'countUserBooking']);
        Route::get('/get-booking/{id}', [BookingController::class, 'getUserBooking']);
    });

    Route::prefix('dashboard')->group(function () {
        Route::get('/booking-this-year', [DashboardController::class, 'bookingEachMonth']);
        Route::get('/interest-this-year', [DashboardController::class, 'interestEachMonth']);
        Route::get('/income-this-month', [DashboardController::class, 'incomeAfterExpense']);
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/today', [DashboardController::class, 'getCheckinToday']);
    });

    Route::prefix('checkin')->group(function () {
        Route::get('/export', [CheckinController::class, 'exportData'])->name('export');
        Route::get('/', [CheckinController::class, 'index'])->name('checkin');
        Route::post('/checkin-detail', [CheckinController::class, 'viewDetail'])->name('updateProfile');
        Route::delete('/checkin', [CheckinController::class, 'removeCheckin'])->name('delCheck');
    });

    Route::prefix('room')->group(function () {
        Route::get('/', [RoomController::class, 'index'])->name('room');
        Route::get('/import', [RoomController::class, 'importData'])->name('import');
        Route::post('/storeRoomFile', [RoomController::class, 'storeRoomFile'])->name('storeRoomFile');
        Route::post('/room-detail', [RoomController::class, 'roomDetail']);
        Route::post('/modify', [RoomController::class, 'updateRoom']);
    });

    Route::prefix('booking')->group(function () {
        Route::get('/', [BookingController::class, 'index'])->name('booking');
        Route::delete('/', [BookingController::class, 'cancel'])->name('delBook');
        Route::post('/show-available-room', [BookingController::class, 'showAvailableRoom'])->name('showAvailableRoom');
        Route::post('/create-booking', [BookingController::class, 'store'])->name('createBooking');
        Route::post('/check-availability', [BookingController::class, 'checkAvailability']);
    });

    Route::get('/guest-statistic', [BookingController::class, 'getGuestStatistic'])->name('guestStatistic');
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('/employee', [EmployeeController::class, 'index'])->name('employee');
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth',
], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
});

Route::prefix('reset-password')->group(function () {
    Route::get('/{token}', [UserController::class, 'linkSent'])->name('password.reset');
    Route::post('/', [UserController::class, 'setNewPassword'])->name('password.update');
});

Route::post('/filter-by-date', [BookingController::class, 'filterByDate'])->name('filterByDate');
Route::post('/filter-room', [RoomController::class, 'filterRoom']);
Route::post('/register', [RegisterController::class, 'register'])->name('register.perform');
Route::get('/email/verify/{id}/{hash}', [UserController::class, 'verifyEmail'])->name('verification.verify');
Route::post('/forgot-password', [UserController::class, 'resetPassword'])->name('password.email');

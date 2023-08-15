<?php

use App\Http\Controllers\bookingController;
use App\Http\Controllers\checkinController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\employeeController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\roomController;
use App\http\Controllers\UserController;
use App\Http\Middleware\VerificationController;
use App\Http\Middleware\VerifyUserRole;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/', function () {
        return redirect()->route('dashboard');
    });
    Route::get('/booking', [BookingController::class, 'index'])->name('booking');

    Route::get('/employee', [EmployeeController::class, 'index'])->name('employee');
    Route::get('/checkin', [CheckinController::class, 'index'])->name('checkin');

    Route::prefix('add')->group(function () {
        Route::post('/', [BookingController::class, 'addBooking']);
        Route::view('/', 'createBooking')->name('createBooking');
    });

    Route::prefix('checked')->group(function () {
        Route::get('/{id}', [BookingController::class, 'checkin'])->name('checked');
        Route::get('/checkout/{id}', [CheckinController::class, 'checkout'])->name('checkout');
        Route::get('/delCheck/{id}', [CheckinController::class, 'destroyCheckin'])->name('delCheck');
        Route::get('/delBook/{id}', [BookingController::class, 'destroyBooking'])->name('delBook');
        Route::post('/addFee', [CheckinController::class, 'updateFee'])->name('addFee');
    });

    Route::prefix('modify')->group(function () {
        Route::view('/', 'modify')->name('modify');
        Route::post('/', [RoomController::class, 'updateRoom']);
    });

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('userlist')->group(function () {
        Route::get('/', [UserController::class, 'index'])->middleware(VerifyUserRole::class)->name('userList');
        Route::get('/delete/{id}', [UserController::class, 'destroy'])->middleware(VerifyUserRole::class)->name('userDestroy');
    });
});

Route::group(['middleware' => ['guest']], function () {

    Route::get('/register', [RegisterController::class, 'show'])->name('register.show');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.perform');
});

Route::get('/room', [RoomController::class, 'index'])->name('room');

// Route::get('/email/verify', function () {
//     return view('room');
// })->middleware('auth')->name('verification.notice');

// Route::post('email/verification-notification', [VerificationController::class, 'sendEmailVerificationNotice'])
// ->middleware(['throttle:6,1'])
// ->name('verification.send');

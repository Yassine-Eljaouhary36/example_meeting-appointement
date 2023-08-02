<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\MeetingController;
use App\Models\ClientVerify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', [MeetingController::class,'index']);
// Route::post('/',[meetingController::class,'store'])->name('store');
 

Route::prefix('customer')->group(function () {
    
    Route::middleware('client.guest')->group(function () {
        Route::get('/login', [LoginController::class, 'showLoginForm'])->name('showLoginForm');
        Route::post('/login', [LoginController::class, 'login'])->name('login');
        Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('showRegistrationForm');
        Route::post('/register', [RegisterController::class, 'register'])->name('register');
    });

    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/commandes', [MeetingController::class,'commandes'])->name('commandes');
    Route::delete('/commandes/{index}', [MeetingController::class, 'destroy'])->name('cart.destroy');

    Route::get('/meetings-panel ', [MeetingController::class,'index'])->name('meetings-panel');
    Route::post('/meetings-panel',[MeetingController::class,'store'])->name('store');
   

    Route::middleware(['client.auth','is_verify_email'])->group(function () {
        // Route::get('/meetings-panel ', [MeetingController::class,'index'])->name('meetings-panel');
        // Route::post('/meetings-panel',[MeetingController::class,'store'])->name('store');
    });

    Route::get('/password/forgot', [LoginController::class, 'showForgotForm'])->name('showForgotForm');
    Route::post('/password/forgot', [LoginController::class, 'sendResetLink'])->name('sendResetLink');
    Route::get('/password/reset/{token}', [LoginController::class, 'showResetForm'])->name('showResetForm');
    Route::post('/password/reset', [LoginController::class, 'resePassword'])->name('resePassword');
});

Route::get('/email/verify/{token}', [RegisterController::class, 'verifyClient'])->name('client.verify'); 

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('client.auth')->name('verification.notice');


Route::post('/email/verification-notification',[RegisterController::class, 'verificationSend'])
    ->middleware(['client.auth', 'throttle:6,1'])->name('verification.send');
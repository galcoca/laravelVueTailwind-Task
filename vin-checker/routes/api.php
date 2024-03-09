<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\ErrorLogController;
use App\Http\Controllers\OtpController;
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

Route::get('/check-authentication', function () {
    $authenticated = Auth::check();
    $user = Auth::user();

    return response()->json([
        'authenticated' => $authenticated,
        'user' => $user,
    ]);
});

Route::post('/error-logger', [ErrorLogController::class, 'store']);
Route::post('/send-otp', [OtpController::class, 'sendOtp']);
Route::post('/verifyPhone', [OtpController::class, 'verifyPhone']);
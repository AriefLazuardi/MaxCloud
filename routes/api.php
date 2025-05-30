<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VPSController;
use App\Models\Notification;

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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/vps', [VPSController::class, 'index']);
    Route::post('/vps', [VPSController::class, 'store']);
    Route::get('/vps/{id}', [VPSController::class, 'show']);
    Route::delete('/vps/{id}', [VPSController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->get('/notifications', function () {
    return Notification::where('user_id', auth()->id())->orderBy('created_at', 'desc')->get();
});

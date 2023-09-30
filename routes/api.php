<?php

use App\Http\Controllers\EventoController;
use App\Http\Controllers\user_controller;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExportExcel;
use App\Http\Controllers\MailController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('/login', [AuthController::class, 'login']);
Route::post('/user', [user_controller::class, 'store']);
Route::post('/email', [MailController::class,'pruebaEmail']);
Route::post('/email/{id}', [MailController::class,'eventMail']);
Route::get('/export', [ExportExcel::class, 'exportEventData']);


Route::middleware('auth:api')->group(function () {
    //authenticate
    Route::post('/logout', [AuthController::class, 'logout']);
    //users
    Route::get('/user', [user_controller::class, 'index']);
    Route::get('/user/{id}', [user_controller::class, 'show']);
    Route::put('/user/{id}', [user_controller::class, 'update']);
    Route::delete('/user/{id}', [user_controller::class, 'destroy']);
    //eventos
    Route::post('/evento', [EventoController::class, 'store']);
    Route::get('/evento/{id}', [EventoController::class, 'show']);
    Route::get('/evento', [EventoController::class, 'index']);
    Route::delete('/evento/{id}', [EventoController::class, 'destroy']);
    Route::post('/evento/{id}', [EventoController::class, 'update']);
});

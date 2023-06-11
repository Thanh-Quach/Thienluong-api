<?php

use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\AuthenticateController;
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

// ADMIN, LOCATION ADMIN, SALE REP ROUTE
Route::post('authenticate', [AuthenticateController::class, 'authenticate']);
Route::resource('schedule', ScheduleController::class);



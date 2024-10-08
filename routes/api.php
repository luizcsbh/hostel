<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TypeOfRoomController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\DailyController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->middleware('jwt.auth')->group(function (){
    Route::post('me', [AuthController::class, 'me']);
    Route::post('logout', [AuthController::class], 'logout');
    Route::resource('type-rooms', TypeOfRoomController::class);
    Route::get('/all-type-rooms', [TypeOfRoomController::class, 'allTypeRooms']);
    Route::resource('dailies', DailyController::class);
    Route::resource('rooms', RoomController::class);
    Route::resource('document-types', DocumentTypeController::class);
});

Route::post('login', [AuthController::class, 'login']);
Route::post('refresh', [AuthController::class, 'refresh']);



<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\TypeOfRoomController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\DocumentTypeController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\ReserveController;
use App\Http\Controllers\CheckInController;
use App\Http\Controllers\CheckOutController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DailyController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin/tipos', function () {
    return view('type-rooms.index');
})->name('tipos')->middleware('auth');

Route::get('/admin/diaria', function () {
    return view('dailies.index');
})->name('diaria')->middleware('auth');

Route::get('/admin/documentos', function () {
    return view('document_types.index');
})->name('documentos')->middleware('auth');
/*
Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function() {
    Route::resource('users', UserController::class);
    // Rotas para a gest�o de Tipos de Quartos
    //Route::resource('type-rooms', TypeOfRoomController::class);
    
    // Rotas para a gest�o de Di�rias
    Route::resource('dailies', DailyController::class);
    
    // Rotas para a gest�o de Quartos
    Route::resource('rooms', RoomController::class);
    
    // Rotas para a gest�o de Tipos de Documentos
    Route::resource('document-types', DocumentTypeController::class);

});



// Rotas para a gest�o de H�spedes
Route::resource('guests', GuestController::class);

// Rotas para a gest�o de Reservas
Route::resource('reserves', ReserveController::class);

// Rotas para a gest�o de Check-ins
Route::resource('checkins', CheckInController::class);

// Rotas para a gest�o de Checkouts
Route::resource('checkouts', CheckOutController::class);

// Rotas para a gest�o de Pagamentos
Route::resource('payments', PaymentController::class);


*/
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

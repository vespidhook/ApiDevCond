<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BilletController;
use App\Http\Controllers\DocController;
use App\Http\Controllers\FoundAndLostController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WallController;
use App\Http\Controllers\WarningController;

Route::get('/ping', function () {
    return ['pong'=>true];
});

Route::get('/401', [AuthController::class, 'unautorized'])->name('login');

Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/register', [AuthController::class, 'register']);

Route::middleware('auth:api')->group(function(){
    Route::post('/auth/validate', [AuthController::class, 'validateToken']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    // Usuarios
    Route::get('/user/{id}/info', [UserController::class, 'getInfo']);
    Route::put('/user/{id}/edit', [UserController::class, 'update']);
    Route::put('/user/{id}/newpassword', [UserController::class, 'newPassword']);

    // Mudal de avisos
    Route::get('/walls', [WallController::class, 'getAll']);
    Route::post('/wall/{id}/like', [WallController::class, 'like']);

    // Documentos
    Route::get('/docs', [DocController::class, 'getAll']);

    // Livro de ocorrencias
    Route::get('/warnings', [WarningController::class, 'getMyWarnings']);
    Route::post('/warning', [WarningController::class, 'setWarning']);
    Route::post('warning/file', [WarningController::class, 'addWarningFile']);

    // Boletos
    Route::get('/billets', [BilletController::class, 'getAll']);

    // Achados e perdido
    Route::get('/foundandlost', [FoundAndLostController::class, 'getAll']);
    Route::post('/foundandlost', [FoundAndLostController::class, 'insert']);
    Route::put('/foundandlost/{id}', [FoundAndLostController::class, 'update']);

    // Unidade
    Route::get('/unit/{id}', [UnitController::class, 'getInfo'])->name('unit.getInfo');
    Route::post('/unit/{id}/addperson', [UnitController::class, 'addPerson'])->name('unit.addPerson');
    Route::post('/unit/{id}/addvehicle', [UnitController::class, 'addVehicle'])->name('unit.addVehicle');
    Route::post('/unit/{id}/addpet', [UnitController::class, 'addPet'])->name('unit.addPet');
    Route::post('/unit/{id}/removeperson', [UnitController::class, 'removePerson'])->name('unit.removePerson');
    Route::post('/unit/{id}/removevehicle', [UnitController::class, 'removeVehicle'])->name('unit.removeVehicle');
    Route::post('/unit/{id}/removepet', [UnitController::class, 'removePet'])->name('unit.removePet');

    // Reservas
    Route::get('/reservations', [ReservationController::class, 'getReservations'])->name('reservations.getReservations');
    Route::post('/reservation/{id}', [ReservationController::class, 'setReservation'])->name('reservation.setReservation');

    Route::get('/reservation/{id}/disableddates', [ReservationController::class, 'getDisabledDates'])->name('reservation.getDisabledDates');
    Route::get('/reservation/{id}/times', [ReservationController::class, 'getTimes']);

    Route::get('/myreservations', [ReservationController::class, 'getMyReservations'])->name('reservations.getMyReservations');
    Route::delete('myreservation/{id}', [ReservationController::class, 'delMyReservation'])->name('reservation.delMyReservation');
});

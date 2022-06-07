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
use App\Http\Controllers\WalletController;
use App\Http\Controllers\WarningController;

Route::get('/ping', function () {
    return ['pong'=>true];
});

Route::get('/401', [AuthController::class, 'unautorized'])->name('401');

Route::post('/auth/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/auth/register', [AuthController::class, 'register'])->name('auth.register');

Route::middlewre('auth:api')->group(function(){
    Route::post('/auth/validade', [AuthController::class, 'validate'])->name('auth.validate');
    Route::post('auth/logout', [AuthController::class, 'logout'])->name('auth.logout');

    // Mudal de avisos
    Route::get('/walls', [WalletController::class, 'getAll'])->name('walls.getAll');
    Route::post('/walls/{id}/like', [WalletController::class, 'like'])->name('walls.like');

    // Documentos
    Route::get('/docs', [DocController::class, 'getAll'])->name('docs.getAll');

    // Livro de ocorrencias
    Route::get('/warnings', [WarningController::class, 'getMyWarnings'])->name('warnings.getMyWarnings');
    Route::post('/warning', [WarningController::class, 'setWarning'])->name('warning.setWarning');
    Route::post('warning/file', [WarningController::class, 'addWarningFile'])->name('warning.addWarningFile');
});

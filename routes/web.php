<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CalculadoraController;
use App\Http\Controllers\CalculadoraDiferidaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HistoryController;

Route::get('/test', function () {
    return view('test');
});

//Página de inicio - Calculadora Anualidades Anticipadas
Route::get('/',[CalculadoraController::class,'index'])->name("inicio");
Route::post('/',[CalculadoraController::class,'calcular'])->name("calcular_anualidad");

//Calculadora diferida
Route::get('/calculadora-diferida',[CalculadoraDiferidaController::class,'index'])->name("calculadora_diferida");
Route::post('/calculadora-diferida',[CalculadoraDiferidaController::class,'renta'])->name("resultado_calculadora_diferida");

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/historial', [HistoryController::class, 'index'])->name('historial')->middleware('auth');
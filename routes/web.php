<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CalculadoraController;
use App\Http\Controllers\CalculadoraDiferidaController;

Route::get('/test', function () {
    return view('test');
});

//Página de inicio - Calculadora Anualidades Anticipadas
Route::get('/',[CalculadoraController::class,'index'])->name("inicio");
Route::post('/',[CalculadoraController::class,'calcular'])->name("calcular_anualidad");

//Calculadora diferida
Route::get('/calculadora-diferida',[CalculadoraDiferidaController::class,'index'])->name("calculadora_diferida");
Route::post('/calculadora-diferida',[CalculadoraDiferidaController::class,'renta'])->name("resultado_calculadora_diferida");
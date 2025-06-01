<?php

use App\Http\Controllers\CorrespondenciaController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

Route::get('/usuarios', [UsuarioController::class,'index'])->name('usuario.index');
Route::post('/usuarios', [UsuarioController::class,'store'])->name('usuario.store');
Route::put('/usuarios/{id}', [UsuarioController::class,'update'])->name('usuario.update');
Route::delete('/usuarios/{id}', [UsuarioController::class,'destroy'])->name('usuario.destroy');

Route::get('/correspondencias', [CorrespondenciaController::class,'index'])->name('correspondencia.index');
Route::post('/correspondencias', [CorrespondenciaController::class,'store'])->name('correspondencia.store');
Route::put('/correspondencias/{id}', [CorrespondenciaController::class,'update'])->name('correspondencia.update');
Route::delete('/correspondencias/{id}', [CorrespondenciaController::class,'destroy'])->name('correspondencia.destroy');


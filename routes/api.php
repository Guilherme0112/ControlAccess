<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CorrespondenciaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Support\Facades\Route;

Route::post("/login", [AuthController::class, "login"])->name("login");
Route::post("/logout", [AuthController::class, "logout"])->name("logout");

Route::middleware(JwtMiddleware::class)->get('/usuarios', [UsuarioController::class,'index'])->name('usuario.index');
Route::middleware(JwtMiddleware::class)->post('/usuarios', [UsuarioController::class,'store'])->name('usuario.store');
Route::middleware(JwtMiddleware::class)->put('/usuarios/{id}', [UsuarioController::class,'update'])->name('usuario.update');
Route::middleware(JwtMiddleware::class)->delete('/usuarios/{id}', [UsuarioController::class,'destroy'])->name('usuario.destroy');

Route::middleware(JwtMiddleware::class)->get('/correspondencias', [CorrespondenciaController::class,'index'])->name('correspondencia.index');
Route::middleware(JwtMiddleware::class)->post('/correspondencias', [CorrespondenciaController::class,'store'])->name('correspondencia.store');
Route::middleware(JwtMiddleware::class)->put('/correspondencias/{id}', [CorrespondenciaController::class,'update'])->name('correspondencia.update');
Route::middleware(JwtMiddleware::class)->delete('/correspondencias/{id}', [CorrespondenciaController::class,'destroy'])->name('correspondencia.destroy');

Route::post('/correspondencias/notificar-chegada', [CorrespondenciaController::class,'send'])->name('correspondencia.send');

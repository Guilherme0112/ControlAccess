<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CorrespondenciaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Middleware\isAdmin;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Support\Facades\Route;

Route::post("/login", [AuthController::class, "login"])->name("login");
Route::middleware(JwtMiddleware::class)->post("/logout", [AuthController::class, "logout"])->name("logout");

Route::middleware([JwtMiddleware::class, isAdmin::class])->get('/usuarios', [UsuarioController::class,'index'])->name('usuario.index');
Route::middleware([JwtMiddleware::class, isAdmin::class])->post('/usuarios', [UsuarioController::class,'store'])->name('usuario.store');
Route::middleware([JwtMiddleware::class, isAdmin::class])->put('/usuarios/{id}', [UsuarioController::class,'update'])->name('usuario.update');
Route::middleware([JwtMiddleware::class, isAdmin::class])->delete('/usuarios/{id}', [UsuarioController::class,'destroy'])->name('usuario.destroy');

Route::middleware([JwtMiddleware::class, isAdmin::class])->get('/correspondencias', [CorrespondenciaController::class,'index'])->name('correspondencia.index');
Route::middleware([JwtMiddleware::class, isAdmin::class])->post('/correspondencias', [CorrespondenciaController::class,'store'])->name('correspondencia.store');
Route::middleware([JwtMiddleware::class, isAdmin::class])->put('/correspondencias/{id}', [CorrespondenciaController::class,'update'])->name('correspondencia.update');
Route::middleware([JwtMiddleware::class, isAdmin::class])->delete('/correspondencias/{id}', [CorrespondenciaController::class,'destroy'])->name('correspondencia.destroy');

Route::middleware(JwtMiddleware::class)->get('/correspondencias/sessao', [CorrespondenciaController::class,'show'])->name('correspondencia.show');
Route::middleware(JwtMiddleware::class)->post('/correspondencias/notificar-chegada', [CorrespondenciaController::class,'notificarRecebimento'])->name('correspondencia.notificarRecebimento');
Route::middleware(JwtMiddleware::class)->post('/correspondencias/aprovar-abertura', [CorrespondenciaController::class,'aprovarAbertura'])->name('correspondencia.aprovarAbertura');
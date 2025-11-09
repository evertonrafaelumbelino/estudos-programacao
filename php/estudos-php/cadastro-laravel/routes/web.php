<?php

use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

require __DIR__.'/api.php';

Route::get('/', [UsuarioController::class, 'cadastrar'])->name('home');
Route::post('/salvar', [UsuarioController::class, 'salvar'])->name('salvar');
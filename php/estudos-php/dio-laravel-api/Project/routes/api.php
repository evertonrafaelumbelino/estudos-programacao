<?php

use App\Http\Controllers\BandController;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HelloWorldController;

Route::middleware('api')->group(function() {
    /*Route::get('/api/hello/{name}', function($name) {
        return "hello " . $name;
    });

    Route::get('/api/hello-post/{name}', [HelloWorldController::class, 'hello']);*/

    // Método get que mostra todas das bandas
    Route::get('/api/bands', [BandController::class, 'getAll']);

    // Método post que adiciona uma nova banda com validação
    Route::post('/api/bands/store', [BandController::class, 'store']);

    // Método get que mostra uma banda com o gênero de id específico
    Route::get('/api/bands/gender/{gender}', [BandController::class, 'getBandsByGender']);
    
    // Método get que mostra uma banda com um id específico
    Route::get('/api/bands/{id}', [BandController::class, 'getById']);
});
<?php

use Illuminate\Support\Facades\Route;
use App\Models\Usuario;

Route::prefix('api/v1')->group(function() {
    Route::get('lista', function() {
        return Usuario::listar(10);
    });

    Route::post('cadastra', "API\Usuario@salvar");
});
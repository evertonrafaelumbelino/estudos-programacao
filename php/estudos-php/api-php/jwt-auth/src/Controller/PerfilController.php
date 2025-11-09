<?php

namespace Controller;

require __DIR__ . "/../../vendor/autoload.php";

use Utils\AuthMiddleware;

class PerfilController {
    // Método para obter o perfil do usuário
    public function obterPerfil() {
        // Verifica se o token é valido
        $usuario = AuthMiddleware::verificarToken();

        // Aqui você pode pegar o perfil do usuário no banco de dados
        // No momento, retornamos apenas o id do usuário como exemplo
        return json_encode(["usuario_id" => $usuario['id']]);
    }
}
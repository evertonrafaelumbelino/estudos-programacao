<?php

namespace Controller;

require __DIR__ . "/../../vendor/autoload.php";

use Utils\tokenJwt;
use Model\User;

class AuthController {
    // Método para login
    public function login($email, $senha) {
        $usuario = User::buscarPorEmail($email); // Simula a busca de um usuário por email

        if ($usuario && password_verify($senha, $usuario['senha'])) {
            // Gera o token JWT
            $token = tokenJwt::gerarToken($usuario['id']);
            return json_encode(["token" => $token]);
        }

        return json_encode(["message" => "Credenciais inválidas"], JSON_UNESCAPED_UNICODE);
    }
}
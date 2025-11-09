<?php

namespace Middleware;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;

// Chave secreta para assinar o token
define("JWT_SECRET", "chave_secreta");

class AuthMiddleware
{
    public static function verificarToken()
    {
        // Verifica se o cabeçalho de autorização foi enviado
        $authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? '';

        if (!$authHeader || !str_starts_with($authHeader, 'Bearer ')) {
            http_response_code(401); // Unauthorized
            echo json_encode(["error" => "Token não fornecido ou inválido"]);
            exit;
        }

        // Obtém apenas o token da string "Bearer <token>
        $token = substr($authHeader, 7);

        try {
            // Decodifica o token
            $decoded = JWT::decode($token, new Key(JWT_SECRET, 'HS256'));

            // Retorna os dados do usuário
            return $decoded;
        } catch (Exception $e) {
            http_response_code(401); // Unauthorized
            echo json_encode(["error" => "Token inválido ou expirado"]);
            exit;
        }
    }
}
<?php

require __DIR__ . "/../vendor/autoload.php";
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

const JWT_SECRET = "chave_secreta_123"; // Mesma chava usada para assinar o token

function validarToken() {
    $headers = getallheaders();

    if (!isset($headers["Authorization"]) || !str_starts_with($headers["Authorization"], "Bearer ")) {
        http_response_code(401); // Não autorizado
        echo json_encode(["error" => "Token ausente ou inválido"]);
        exit;
    }

    $token = str_replace("Bearer ", "", $headers["Authorization"]);

    try {
        return JWT::decode($token, new Key(JWT_SECRET, 'HS256'));
    } catch (Exception $e) {
        http_response_code(401); // Não autorizado
        echo json_encode(["error" => "Token inválido ou expirado"]);
        exit;
    }
}
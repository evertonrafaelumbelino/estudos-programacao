<?php

// Cabeçalho de tipo de contéudo
header('Content-Type: application/json');

// Importa o autoload
require __DIR__ . "/vendor/autoload.php";

// Importaçõs necessárias
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// Chave secreta
define("JWT_SECRET", "chave_secreta");

// Verifica se o token foi enviado
if (!isset($_GET['token'])) {
    http_response_code(400); // Bad Request
    echo json_encode(["error" => "Token não enviado"]);
    exit;
}

// Armazena o token enviado
$token = $_GET['token'] ?? ''; // Evita warninh caso 'token' não exista

if (empty($token)) {
    http_response_code(400); // Bad Request
    echo json_encode(["error" => "Token não enviado"]);
    exit;
}

// Tenta decodificar o token
try {
    $tokenDecoded = JWT::decode($token, new Key(JWT_SECRET, 'HS256'));
} catch (Exception $e) {
    $tokenDecoded = false;
}

// Verifica se o token foi decodificado
if ($tokenDecoded) {
    echo json_encode(["user" => $tokenDecoded]);
    exit;
} else {
    http_response_code(400); // Bad Request
    echo json_encode(["error" => "Token inválido ou expirado"]);
    exit;
}
<?php

// Cabeçalho de tipo de contéudo
header('Content-Type: application/json');

// Importando as configurações do autoload
require __DIR__ . "/vendor/autoload.php";

// Importando a classe JWT
use Firebase\JWT\JWT;

// Chave secreta
define("JWT_SECRET", "chave_secreta");

// Dados do usuário
$payload = [
    "user_id" => 123,
    "email" => "usuario@email.com",
    "exp" => time() + 3600 // Expira em 1 hora
];

// Gera o token
$token = JWT::encode($payload, JWT_SECRET, 'HS256');

// Imprime o token gerado
echo json_encode(["token" => $token]);
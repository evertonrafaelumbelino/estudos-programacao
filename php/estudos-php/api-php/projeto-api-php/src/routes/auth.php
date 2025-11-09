<?php

require __DIR__ . '/../../vendor/autoload.php';

use Firebase\JWT\JWT;

// Define um cabeçalho JSON
header('Content-Type: application/json');

// Chave secreta para assinar o token
define("JWT_SECRET", "chave_secreta");

// Dados fictícios do usuário (simulando um login)
$usuario = [
    "id" => 1,
    "email" => "usuario@email.com",
    "name" => "Usuário Teste"
];

// Define a carga útil (payload) do JWT
$payload = [
    "user_id" => $usuario["id"],
    "email" => $usuario["email"],
    "name" => $usuario["name"],
    "exp" => time() + 3600 // Expira em 1 hora
];

// Gera o token JWT
$token = JWT::encode($payload, JWT_SECRET, 'HS256');

// Retorna o token gerado
echo json_encode(["token" => $token]);
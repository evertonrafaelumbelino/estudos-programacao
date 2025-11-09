<?php

require __DIR__ . "/../vendor/autoload.php";
use Firebase\JWT\JWT;

header("Content-Type: application/json");

const JWT_SECRET = "chave_secreta_123"; // Chave secreta para assinatura do token

// Simulação de credenciais de usuário
$usuarios = [
    "user@example.com" => "123456"
];

// Armazena os valores enviados pelo usuário
$input = json_decode(file_get_contents("php://input"), true);

// Verifica se o usuário enviou os campos necessários
if (!isset($input["email"], $input["senha"])) {
    echo json_encode(["error" => "Email e senha são obrigatórios"]);
    http_response_code(400); // Bad Request
    exit;
}

// Verifica se o usuário existe e a senha está correta
if (!isset($usuarios[$input["email"]]) || $usuarios[$input["email"]] !== $input["senha"]) {
    echo json_encode(["error" => "Credenciais inválidas"]);
    http_response_code(401); // Não autorizado
    exit;
}

// Gerar o token JWT
$payload = [
    "email" => $input["email"],
    "exp" => time() + 3600 // Token expira em 1 hora
];

$token = JWT::encode($payload, JWT_SECRET, 'HS256');

echo json_encode(["token" => $token]);
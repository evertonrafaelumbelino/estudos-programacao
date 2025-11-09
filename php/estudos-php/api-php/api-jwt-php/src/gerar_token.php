<?php

require 'config.php'; // Importa a configuração com a chave secreta
use Firebase\JWT\JWT; // Importa a classe JWT

// Dados do usuário (normalmente viriam do banco de dados)
$payload = [
    "sub" => 1, // ID do usuário
    "name" => "Usuário Exemplo",
    "email" => "usuario@email.com",
    "iat" => time(), // Tempo de emissão do token
    "exp" => time() + (60 * 60) // Expira em 1 hora
];

// Gera o token JWT
$token = JWT::encode($payload, JWT_SECRET, 'HS256');

// Retorna o token como JSON
echo json_encode(["token" => $token]);
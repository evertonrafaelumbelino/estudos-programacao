<?php
require_once '../src/config.php'; // Importa confing.php
require_once '../src/jwt-utils.php'; // Importa jwt-utils.php

// Header
header('Content-Type: application/json');

// Variável que armazena a rota enviada na query string por GET
$rota = $_GET['rota'] ?? '';

// Rota para gerar um token (simulando um login)
if ($rota === 'login') {
    $payload = [
        'sub' => 1, // ID do usuário
        'iat' => time(), // Data de emissão
        'exp' => time() + 3600 // Expira em 1 hora
    ];

    $token = gerar_token($payload);
    echo json_encode(['token' => $token]);
}

// Rota protegida que exige autenticação JWT
elseif ($rota === 'protegida') {
    $headers = getallheaders();
    $authHeader = $headers['Authorization'] ?? '';

    if (!$authHeader || !str_starts_with($authHeader, 'Bearer ')) {
        http_response_code(401); // Não autorizado
        echo json_encode(['message' => 'Token ausente ou inválido']);
        exit;
    }

    $token = str_replace('Bearer ', '', $authHeader);
    $dados = validar_token($token);

    if (!$dados) {
        http_response_code(401); // Não autorizado
        echo json_encode(['message' => 'Token inválido ou expirado']);
        exit;
    }

    echo json_encode(['message' => 'Acesso permitido', 'dados' => $dados]);
}

// Rota não encontrada
else {
    http_response_code(404);
    echo json_encode(['message' => 'Rota não encontrada']);
}
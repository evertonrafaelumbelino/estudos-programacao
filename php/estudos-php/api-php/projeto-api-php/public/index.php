<?php

require __DIR__ . '/../vendor/autoload.php';

// Define o cabeçalho para JSON
header('Content-Type: application/json');

// Obtém a URL da requisição
$url = $_GET['url'] ?? '';

// Roteamento básico
switch ($url) {
    case 'auth':
        require __DIR__ . '/../src/routes/auth.php';
        break;

    case 'users':
        require __DIR__ . '/../src/routes/users.php';
        break;

    default:
        echo json_encode(["error" => "Rota não encontrada"]);
        http_response_code(404); // Not Found
}
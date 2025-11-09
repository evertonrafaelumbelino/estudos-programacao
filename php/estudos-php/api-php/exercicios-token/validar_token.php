<?php

// Cabeçalho de tipo de contéudo
header('Content-Type: application/json');

// Verifica se um token foi enviado na query string
if (!isset($_GET['token'])) {
    http_response_code(400); // Bad Request
    echo json_encode(["error" => "Token não fornecido!"]);
    exit;
}

// Armazena o token enviado na query string
$token = $_GET['token'];

// Armazena os valores do arquivo de tokens
$tokens = array_map('trim', file('tokens.txt', FILE_IGNORE_NEW_LINES)); // Remove espaços extras

// Verifica se o token está dentro do arquivo
if (in_array($token, $tokens)) {
    echo json_encode(["message" => "Token válido!"]);
    exit;
} else {
    http_response_code(400); // Bad Request
    echo json_encode(["error" => "Token inválido!"]);
    exit;
}
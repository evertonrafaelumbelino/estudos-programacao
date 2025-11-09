<?php

// Cabeçalho de tipo de contéudo
header('Content-Type: application/json');

// Gera um token de 32 caracteres
$token = bin2hex(random_bytes(32));

// Atualiza o arquivo dos tokens com token gerado, e coloca um ; seguido de uma quebra de linha
file_put_contents('tokens.txt', $token . "\n", FILE_APPEND);

// Imprime o token
echo json_encode(["token" => $token]);
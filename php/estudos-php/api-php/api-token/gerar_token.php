<?php

// Gerar um token aleatório
$token = bin2hex(random_bytes(32));

// Definir a data de expiração (10 minutos a partir de agora)
$expiration = time() + (10 * 60); // Tempo atual + 600 segundos

// Criar um array com os dados do token
$tokenData = [
    "token" => $token,
    "expires_at" => $expiration
];

// Carregar tokens existentes do arquivo JSON (se houver)
$tokensFile = "tokens.json";
$tokens = file_exists($tokensFile) ? json_decode(file_get_contents($tokensFile), true) : [];

// Adicionar o novo token à lista
$tokens[] = $tokenData;

// Salvar de volta no arquivo JSON
file_put_contents($tokensFile, json_encode($tokens, JSON_PRETTY_PRINT));

echo "Token gerado: " . $token;
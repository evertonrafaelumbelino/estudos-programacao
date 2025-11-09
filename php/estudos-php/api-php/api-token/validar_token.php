<?php

// Obter os cabeçalhos da requisição
$headers = getallheaders();

// Verifica se o cabeçalho "Authorization" foi declarado e tem valor
if (!isset($headers["Authorization"])) {
    die("Erro: Token não enviado.");
}

// Remover "Bearer " e obter apenas o token
$token = str_replace("Bearer ", "", $headers["Authorization"]);

// Carregar os tokens salvos
$tokensFile = "tokens.json";
$tokens = file_exists($tokensFile) ? json_decode(file_get_contents($tokensFile), true) : [];

// Procurar o token na lista
$tokenValido = false;

// Percore os tokens e faz as verificações necessárias
foreach ($tokens as $t) {
    if ($t["token"] === $token) {
        if ($t["expires_at"] > time()) {
            $tokenValido = true;
            break;
        } else {
            die("Erro: Token expirado.");
        }
    }
}

if ($tokenValido) {
    echo "Acesso permitido";
} else {
    die("Erro: Token inválido.");
}
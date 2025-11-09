<?php
header("Content-Type: application/json");

// Obtém o cabeçalho Authorization
$headers = getallheaders();

// Verifica se o cabeçalho "Authorization" foi declarado ou tem valor
if (!isset($headers["Authorization"])) {
    echo json_encode(["erro" => "Token não fornecido"]);
    exit();
}

// Remove a palavra "Bearer" do cabeçalho "Authorization"
$token = str_replace("Bearer ", "", $headers["Authorization"]);

// Lê o arquivo "tokens.txt" e retorna um array onde cada linha é um item
$tokens = file("tokens.txt", FILE_IGNORE_NEW_LINES);

// Verifica se o valor do token($token) existe dentro do arquivo/lista de tokens($tokens)
if (in_array($token, $tokens)) {
    echo json_encode(["menssagem" => "Acesso permitido"]);
} else {
    echo json_encode(["erro" => "Token inválido"]);
}
?>
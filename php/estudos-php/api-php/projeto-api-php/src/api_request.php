<?php

// Define a URL da API externa (exemplo: API pública de usuários)
$apiUrl = "https://jsonplaceholder.typicode.com/users";

// Inicializa o cURL
$ch = curl_init();

// Configurações da requisição
curl_setopt($ch, CURLOPT_URL, $apiUrl); // Define a URL
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Retorna o resultado como string

// Executa a requisição
$response = curl_exec($ch);

// Verifica se houve um erro na requisição

if ($response === false) {
    echo "Erro na requisição:" . curl_error($ch);
    exit;
}

// Fecha a conexão cURL
curl_close($ch);

// Converte a resposta JSON para um array PHP
$data = json_decode($response, true);

// Exibe os dados recebidos
echo json_encode($data, JSON_PRETTY_PRINT);
<?php

// Define o tipo de conteúdo que a resposta JSON vai ter
header('Content-Type: application/json');

// Obter o método HTTP usado na requisição
$method = $_SERVER['REQUEST_METHOD'];

// Exercício 1: Obter a URL do site
$uri = $_SERVER['REQUEST_URI'];

// Exercício 1: Envia uma resposta na requisição get na url /api.php/sobre
if (strpos($uri, '/api.php/sobre') === 0 && $method == 'GET') {
    $response = [
        "nome" => "Minha API",
        "versao" => "1.0"
    ];

    echo json_encode($response);
    exit();
} 

// Exercício 3: Verifica se o parâmetro nome é enviado na query string
if (strpos($uri, '/api.php/saudacao') === 0 && $method == 'GET') {
    $nome = $_GET['nome'] ?? null;
    if ($nome) {
        $response = [
            "message" => "Olá, $nome! Bem-vindo à nossa API!"
        ];
        
        echo json_encode($response);
        exit();
    } else {
        $http_status = 400; // Status code 400 = Bad Request
        $response = [
            "error" => "O parâmetro 'nome' é obrigatório"
        ];

        http_response_code($http_status);
        echo json_encode($response);
        exit();
    }
}


// Estrutura inicial da resposta
$response = [];
$http_status = 200; // Status code padrão: OK

// Verificação do método da requisição
if ($method == 'GET') {
    $response = [
        'message' => 'Você fez uma requisição do tipo GET!'
    ];
} elseif ($method == 'POST') {

    // No método POST, vamos pegar os dados enviados no corpo da requisição
    $input = json_decode(file_get_contents('php://input'), true);
    
    // Verificar se os campos obrigatórios foram enviados
    if (!isset($input['nome']) || !isset($input['idade'])) {
        $http_status = 400; // Status code 400 = Bad Request
        $response = [
            'error' => 'Campos obrigatórios não enviados. Envie nome e idade.'
        ];
    } else {

        // Exercício 2: Verifica se a idade está entre 1 e 120 anos
        if ($input['idade'] < 1 || $input['idade'] > 120) {
            $http_status = 400; // Status code 400 = Bad Request
            $response = [
                'error' => 'A idade deve estar entre 1 e 120 anos.'
            ];
        } else {
            $response = [
                'message' => 'Dados da requisição POST recebidos com sucesso!',
                'data' => $input
            ];
        }
    }
} else {
    $http_status = 405; // Status code 405 = Método não permitido
    $response = [
        'error' => 'Método HTTP não é permitido. Use GET ou POST.'
    ];
}

// Define o código de status HTTP
http_response_code($http_status);

// Enviar a resposta no formato JSON
echo json_encode($response);
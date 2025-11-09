<?php
header("Content-Type: application/json");

// Simulando um usuário cadastrado no sistema
$usuarios_correto = "usuario@email.com";
$senha_correta = "123456";

// Recebe os dados enviados pelo cliente
$dados = json_decode(file_get_contents("php://input"), true);

// Verifica se o cliente enviou os dados corretamente
if (!isset($dados["email"]) || !isset($dados["senha"])) {
    echo json_encode(["erro" => "Informe email e seha"]);
    exit();
}

// Guarda os valores enviados pelo usuário
$email = $dados["email"];
$senha = $dados["senha"];

// Verifica se os valores enviados pelo usuário são identicos aos que seriam "corretos"
if ($email === $usuarios_correto && $senha === $senha_correta) {
    // Gera um token aleatório (simplesmente um hash aleatório)
    $token = bin2hex(random_bytes(32));

    // Salva o token em um arquivo (simulação de um banco de dados)
    file_put_contents("tokens.txt", "$token\n", FILE_APPEND);

    echo json_encode(["token" => $token]);
} else {
    echo json_encode(["erro" => "Credenciais inválidas"]);
}
?>
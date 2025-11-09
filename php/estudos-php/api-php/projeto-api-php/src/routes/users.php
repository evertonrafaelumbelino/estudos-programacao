<?php

require_once __DIR__ . '/../middlewares/AuthMiddleware.php';

use Middleware\AuthMiddleware;

// Define o cabeçalho da resposta como JSON
header('Content-Type: application/json');

// Protege a rota verificando o token
$usuario = AuthMiddleware::verificarToken();

// Se passou na verificação, retorna os dados do usuário autenticado
echo json_encode([
    "message" => "Rota protegida acessada com sucesso!",
    "user" => $usuario
]);
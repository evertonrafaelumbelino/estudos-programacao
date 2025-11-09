<?php

require_once '../vendor/autoload.php';
require_once '../src/Utils/Jwt.php';
require_once '../src/Controller/AuthController.php';
require_once '../src/Controller/PerfilController.php';

use Controller\AuthController;
use Controller\PerfilController;

// Simulação de rota de login
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_SERVER['REQUEST_URI'] == '/login') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['email']) && isset($data['senha'])) {
        $authController = new AuthController();
        echo $authController->login($data['email'], $data['senha']);
    } else {
        echo json_encode(["message" => "Campos 'email' e 'senha' são obrigatórios"], JSON_UNESCAPED_UNICODE);
    }
}

// Rota protegida
if ($_SERVER['REQUEST_METHOD'] == 'GET' && $_SERVER['REQUEST_URI'] == '/perfil') {
    $perfilController = new PerfilController();
    echo $perfilController->obterPerfil();
}
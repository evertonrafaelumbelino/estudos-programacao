<?php
require "middleware.php";

header("Content-Type: application/json");

// Valida o token antes de continuar
$dadosUsuario = validarToken();

echo json_encode([
    "message" => "Acesso concedido",
    "user" => $dadosUsuario
]);
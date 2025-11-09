<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Acess-Control-Allow-Headers: Content-Type, Authorization");

$rota = $_GET['route'] ?? "";

// Definir as rotas disponíveis
switch ($rota) {
    case "auth":
        require "src/auth.php";
        break;
    case "protected":
        require "src/protected.php";
        break;
    default:
        http_response_code(404); // Not Found
        echo json_encode(["error" => "Rota não encontrada"]);
}
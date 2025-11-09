<?php
require __DIR__ . "/../vendor/autoload.php"; // Carregar a biblioteca JWT

use Firebase\JWT\JWT; // Importa a classe JWT
use Firebase\JWT\Key; // Importa a classe Key

// Cria uma constante com a "chave secreta"
define("JWT_SECRET", "sua-chave-secreta-aqui");

// Função para validar o token
function validarToken($token) {
    try {
        // Decodifica o token e verifica a assinatura
        $decoded = JWT::decode($token, new Key(JWT_SECRET, 'HS256'));

        return $decoded; // Retorna os dados do usuário (payLoad)
    } catch (Exception $e) {
        return false; // Retorna falso se o token for inválido ou expirado
    }
}
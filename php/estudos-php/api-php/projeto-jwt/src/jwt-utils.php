<?php
require_once __DIR__ . "/../vendor/autoload.php";
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// Função para gerar um token JWT
function gerar_token($payload) {
    return JWT::encode($payload, JWT_SECRET, 'HS256');
}

// Função para validar um token JWT
function validar_token($token) {
    try {
        return JWT::decode($token, new Key(JWT_SECRET, 'HS256'));
    } catch (Exception $e) {
        return false; // Token inválido ou expirado
    }
}
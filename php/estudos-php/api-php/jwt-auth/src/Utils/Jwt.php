<?php

namespace Utils;

require __DIR__ . "/../../config/config.php";
require __DIR__ . "/../../vendor/autoload.php";

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class tokenJwt {
    // Função para gerar o JWT
    public static function gerarToken($usuarioId) {
        $data = array(
            "iat" => time(), // Hora de emissão
            "exp" => time() + EXPIRACAO_TOKEN, // Expiração
            "data" => array(
                "id" => $usuarioId
            )
        );

        return JWT::encode($data, SECRET_KEY, ALGORITMO); // Gera o JWT
    }

    // Função para decodificar o JWT
    public static function decodificarToken($jwt) {
        try {
            $decoded = JWT::decode($jwt, new Key(SECRET_KEY, ALGORITMO));
            return (array) $decoded->data; // Retorna a parte 'data' do token
        } catch (Exception $e) {
            return null; // Retorna null se o token for inválido
        }
    }
}
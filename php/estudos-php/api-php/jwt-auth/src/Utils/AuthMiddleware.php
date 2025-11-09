<?php

namespace Utils;

use Exception;

class AuthMiddleware {
    public static function verificarToken() {
        // Verifica se o cabeçalho 'Authorization está presente
        $headers = getallheaders();
        if (!isset($headers['Authorization'])) {
            http_response_code(401);
            echo json_encode(["message" => "Token não fornecido"]);
            exit();
        }

        // Extrai o token do cabeçalho
        $authorizationHeader = $headers['Authorization'];
        list($tipo, $token) = explode(" ", $authorizationHeader);

        // Verifica se o token tem o formato correto (Bearer)
        if ($tipo !== 'Bearer' || !$token) {
            http_response_code(401);
            echo json_encode(["message" => "Token inválido"]);
            exit();
        }

        // Tenta decodificar o token
        $dados = tokenJwt::decodificarToken($token);

        if (!$dados) {
            http_response_code(401);
            echo json_encode(["message" => "Token inválido ou expirado"]);
            exit();
        }

        // Retorna os dados do token decodificado para o uso posterior
        return $dados;
    }
}
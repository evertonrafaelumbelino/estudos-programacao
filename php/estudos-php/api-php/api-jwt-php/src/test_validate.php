<?php
require "validate_token.php";

$token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEsIm5hbWUiOiJVc3VcdTAwZTFyaW8gRXhlbXBsbyIsImVtYWlsIjoidXN1YXJpb0BlbWFpbC5jb20iLCJpYXQiOjE3NDAyMzI3MDYsImV4cCI6MTc0MDIzNjMwNn0.b0fXWrLBP6ABrULBzoO67VzCQciiK2RRXaz1PcNClP4"; // Token JWT válido

$dados = validarToken($token);

if ($dados) {
    echo "Token válido!\n";
    print_r($dados);
} else {
    echo "Token inválido ou expirado!";
}
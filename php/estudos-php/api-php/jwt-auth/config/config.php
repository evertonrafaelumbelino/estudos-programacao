<?php
// Chave secreta para assinar o JWT
define('SECRET_KEY', 'sua-chave-secreta-aqui');
define('ALGORITMO', 'HS256'); // Algoritmo para assinar o token (HMAC SHA-256)
define('EXPIRACAO_TOKEN', 3600); // Expiração do token sem segundos (1 hora)
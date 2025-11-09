<?php

namespace Model;

class User {
    public static function buscarPorEmail($email) {
        // Usuário fictício apenas para fins de teste
        $usuarios = [
            'usuario@teste.com' => [
                'id' => 1,
                'email' => 'usuario@teste.com',
                'senha' => password_hash('senha123', PASSWORD_BCRYPT) // Senha criptografada
            ]
        ];

        return isset($usuarios[$email]) ? $usuarios[$email] : null;
    }
}
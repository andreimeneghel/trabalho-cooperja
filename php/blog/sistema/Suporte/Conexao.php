<?php

namespace sistema\Suporte;

use Exception;
use PDO;
use PDOException;

class Conexao
{

    private static $instancia;

    public static function getInstancia(): PDO
    {

        if (empty(self::$instancia)) {

            try {

                define('DB_HOST', '127.0.0.1');
                define('DB_PORTA', '3306');
                define('DB_NOME', 'escola_db');
                define('DB_USUARIO', 'coop-leandro');
                define('DB_SENHA', 'viveocampo');


                self::$instancia = new PDO('mysql:host=' . DB_HOST . ';port=' . DB_PORTA . ';dbname=' . DB_NOME, DB_USUARIO, DB_SENHA, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                    PDO::ATTR_CASE => PDO::CASE_NATURAL
                ]);
            } catch (PDOException $e) {
                die("Erro de conexão" . $e->getMessage());
            }
        }
        return self::$instancia;
    }

    protected function __construct() {}

    protected function __clone(): void {}
}

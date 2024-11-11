<?php

namespace Sistema\Suporte;

class Helpers{

    
    public static function url(?string $url = null): string {
        $servidor = filter_input(INPUT_SERVER, 'SERVER_NAME');
        $ambiente = ($servidor === 'localhost' ? URL_DESENVOLVIMENTO : URL_PRODUCAO);
    
        
        if (is_null($url) || $url === '') {
            return $ambiente . '/'; 
        }
    
        return str_starts_with($url, '/') ? $ambiente . $url : $ambiente . '/' . $url;
    }

    public static function redirecionar(string $url = null): void
    {
        header('HTTP/1.1 302 Found');

        $local = ($url ? self::url($url) : self::url());

        header("Location: {$local} ");

        exit;
    }

    /**
     * Função que Valida um Email com filter_validate_email
     * @param string $email recebe um email válido
     * @return bool retorna true se for válido, false caso contrário
     */
    public static function validarEmail(string $email): bool {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }



}
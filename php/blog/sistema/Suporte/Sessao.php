<?php

namespace Sistema\Suporte;

class Sessao {
    public function __construct() {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    public function criar(string $chave, mixed $valor): Sessao {
        $_SESSION[$chave] = is_array($valor) ? (object) $valor : $valor;
        return $this;
    }

    public function carregar(): ?object {
        return (object) $_SESSION;
    }

    public function checar(string $chave): bool {
        return isset($_SESSION[$chave]);
    }

    public function limpar(string $chave): Sessao {
        unset($_SESSION[$chave]);
        return $this;
    }

    public function deletar(): Sessao {
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
        return $this;
    }

    public function __get($atributo) {
        return $_SESSION[$atributo] ?? null;
    }
    
    //não tem função mensagem se quiser usar tem que criar
    
    // public function flash(): 
    // {
    //     if($this->checar('flash')){
    //         $flash = $this->flash;
    //         $this->limpar('flash');
    //         return $flash;
    //     }
    //     return null;
    // }
}
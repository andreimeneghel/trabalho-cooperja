<?php

namespace sistema\Controlador;

class teste {

    public function redirecionar(): void {
        header('Location: http://localhost:8000/templates/site/views/loginUsuario.html');
        exit();
    }
}

?>
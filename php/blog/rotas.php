<?php

use Pecee\SimpleRouter\SimpleRouter;
use Pecee\Http\Request;
use sistema\Suporte\Helpers;

try {
    SimpleRouter::get('/', function() {
        require 'templates/site/views/loginUsuario.php';
    });

    SimpleRouter::get('/dashboard', function() {
        require 'templates/site/views/dashboard.php';
    });

    SimpleRouter::get('/turmas', function() {
        require 'templates/site/views/formNotas.php';
    });
    
    SimpleRouter::get('/alunos', function() {
        require 'templates/site/views/alunos.php';
    });

    SimpleRouter::get('/academico', function() {
        require 'templates/site/views/academicos.php';
    });

    SimpleRouter::get('/academico/informacoes', function() {
        require 'templates/site/views/tabela_academicos.php';
    });

    SimpleRouter::get('/configuracoes', function() {
        require 'templates/site/views/configuracaoProf.php';
    });

    SimpleRouter::start();

} catch(Pecee\SimpleRouter\Exceptions\NotFoundHttpException $ex) {
    if(Helpers::localhost()) {
        echo $ex;
    } else {
        Helpers::redirecionar('404');
    }
}

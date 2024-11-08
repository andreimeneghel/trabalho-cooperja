<?php

require './vendor/autoload.php';

use Pecee\SimpleRouter\SimpleRouter;
use sistema\Nucleo\Helpers;



try {
    // Defina o namespace padrão para os controladores
    SimpleRouter::setDefaultNamespace('sistema\\Controlador'); // Certifique-se de que o namespace está correto

    // Definindo as rotas
    SimpleRouter::get(URL_SITE, 'SiteControlador@index');
    SimpleRouter::get(URL_SITE . 'sobre-nos', 'SiteControlador@sobre');
    SimpleRouter::get(URL_SITE . 'post/{id}', 'SiteControlador@post');
    SimpleRouter::get(URL_SITE . 'categoria/{id}', 'SiteControlador@categoria');
    SimpleRouter::post(URL_SITE . 'buscar', 'SiteControlador@buscar');
    SimpleRouter::get(URL_SITE . '404', 'SiteControlador@erro404');

    // Grupo de rotas para Admin
    SimpleRouter::group(['namespace' => 'Admin'], function () {
    SimpleRouter::get(URL_ADMIN . 'dashboard', 'AdminDashboard@dashboard');

        // ADMIN POSTS
        SimpleRouter::get(URL_ADMIN . 'posts/listar', 'AdminPosts@listar');
        SimpleRouter::match(['get', 'post'], URL_ADMIN . 'posts/cadastrar', 'AdminPosts@cadastrar');
        SimpleRouter::match(['get', 'post'], URL_ADMIN . 'posts/editar/{id}', 'AdminPosts@editar');
        SimpleRouter::get(URL_ADMIN . 'posts/deletar/{id}', 'AdminPosts@deletar');

        // ADMIN CATEGORIAS
        SimpleRouter::get(URL_ADMIN . 'categorias/listar', 'AdminCategorias@listar');
        SimpleRouter::match(['get', 'post'], URL_ADMIN . 'categorias/cadastrar', 'AdminCategorias@cadastrar');
        SimpleRouter::match(['get', 'post'], URL_ADMIN . 'categorias/editar/{id}', 'AdminCategorias@editar');
        SimpleRouter::get(URL_ADMIN . 'categorias/deletar/{id}', 'AdminCategorias@deletar');
    });

    // Inicia o roteador
    SimpleRouter::start();

} catch (Pecee\SimpleRouter\Exceptions\NotFoundHttpException $ex) {
    // Exibição do erro dependendo do ambiente
    if (Helpers::localhost()) {
        echo $ex;  // Para localhost, exibe o erro completo
    } else {
        Helpers::redirecionar('404');  // Para produção, redireciona para página 404
    }
}

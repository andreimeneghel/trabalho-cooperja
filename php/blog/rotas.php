<?php

use Pecee\SimpleRouter\SimpleRouter;
use Pecee\Http\Request;
use sistema\Suporte\Helpers;

try {
    SimpleRouter::get('/', function() {
        require 'templates/site/views/loginUsuario.php';
    });

    SimpleRouter::get('/assets/{path}', function (Request $request) {
        $path = $request->getParam('path');
        $file = __DIR__ . '/templates/site/assets/' . $path;
    
        if (file_exists($file)) {
            $mimeType = mime_content_type($file);
            header("Content-Type: {$mimeType}");
            header("Cache-Control: public, max-age=31536000");
            readfile($file);
            exit;
        } else {
            http_response_code(404);
            echo 'File not found';
        }
    })->where(['path' => '.*']);

    // SimpleRouter::get(URL_SITE.'sobre-nos','SiteControlador@sobre');
    // SimpleRouter::get(URL_SITE.'post/{id}','SiteControlador@post');
    // SimpleRouter::get(URL_SITE.'categoria/{id}','SiteControlador@categoria');
    // SimpleRouter::post(URL_SITE.'buscar','SiteControlador@buscar');

    // SimpleRouter::get(URL_SITE.'404', 'SiteControlador@erro404');

    // SimpleRouter::group(['namespace' => 'Admin'], function () {
    //     SimpleRouter::get(URL_ADMIN.'dashboard', 'AdminDashboard@dashboard');

    //     // ADMIN POSTS
    //     SimpleRouter::get(URL_ADMIN.'posts/listar', 'AdminPosts@listar');
    //     SimpleRouter::match(['get','post'], URL_ADMIN.'posts/cadastrar',
    //     'AdminPosts@cadastrar');
    //     SimpleRouter::match(['get','post'], URL_ADMIN.'posts/editar/{id}',
    //     'AdminPosts@editar');
    //     SimpleRouter::get(URL_ADMIN.'posts/deletar/{id}',
    //     'AdminPosts@deletar');

    //     // ADMIN CATEGORIAS
    //     SimpleRouter::get(URL_ADMIN.'categorias/listar', 'AdminCategorias@listar');
    //     SimpleRouter::match(['get','post'], URL_ADMIN.'categorias/cadastrar',
    //      'AdminCategorias@cadastrar');
    //      SimpleRouter::match(['get','post'], URL_ADMIN.'categorias/editar/{id}',
    //      'AdminCategorias@editar');
    //      SimpleRouter::get(URL_ADMIN.'categorias/deletar/{id}',
    //      'AdminCategorias@deletar');
    // });

    SimpleRouter::start();

} catch(Pecee\SimpleRouter\Exceptions\NotFoundHttpException $ex) {
    if(Helpers::localhost()) {
        echo $ex;
    } else {
        Helpers::redirecionar('404');
    }
}
<?php

use Pecee\SimpleRouter\SimpleRouter;
use sistema\Suporte\Helpers;


try {

    SimpleRouter::setDefaultNamespace('sistema\Controlador');
    SimpleRouter::get('/', "teste@redirecionar");

SimpleRouter::start();


}   catch(Pecee\SimpleRouter\Exceptions\NotFoundHttpException $ex){
    if(Helpers::localhost())
    {
        echo $ex;
    }
    else {
        Helpers::redirecionar('404');
    }
};
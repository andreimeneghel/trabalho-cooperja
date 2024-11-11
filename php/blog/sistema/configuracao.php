<?php
//echo"Arquivo de Configuração do Sistema";
//define o horario
date_default_timezone_set('America/Sao_Paulo');

//mudar esses defines
define('DB_HOST','127.0.0.1');
define('DB_PORTA','3306');
define('DB_NOME','escola_db');
define('DB_USUARIO','root');
define('DB_SENHA','Andrei123!');

//informações do site
define('SITE_NOME','Cooperja');
define('SITE_DESCRIÇÃO','Cooperja SLA');

//urls do sistema
define('URL_PRODUCAO','http://localhost:8081/php/blog');
define('URL_DESENVOLVIMENTO','http://localhost:8801/php/blog');



define('URL_SITE','/');


// define('URL_ADMIN','/projeto01/admin/');
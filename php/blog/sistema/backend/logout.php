<?php

require_once '../Suporte/Sessao.php';

use Sistema\Suporte\Sessao;

$sessao = new Sessao();
$sessao->deletar();

header("Location: /");
exit;

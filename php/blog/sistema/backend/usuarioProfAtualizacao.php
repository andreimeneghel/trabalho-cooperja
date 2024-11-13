<?php

require '../Suporte/Sessao.php';
require '../Modelo/UsuarioModelo.php';

use Sistema\Suporte\Sessao;
use sistema\Modelo\UsuarioModelo;

$sessao = new Sessao;
$user = new UsuarioModelo;
$id = $sessao->user_id;

echo $id;

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
var_dump($dados);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    echo "bbbbb";

    $email = filter_var($dados['email'], FILTER_SANITIZE_EMAIL);
    $password = $dados['password'];

    if (empty($email)) {
        $_SESSION['flash_message'] = ['type' => 'danger', 'message' => 'Email vazio.'];
        header('Location: /mudarcadprof');
        exit;
    } 

    if (empty($password)) {
        $_SESSION['flash_message'] = ['type' => 'danger', 'message' => 'Senha vazia.'];
        header('Location: /mudarcadprof');
        exit;
    } 

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['flash_message'] = ['type' => 'danger', 'message' => 'Email inválido.'];
        echo "zzzzzz";
        header('Location: /mudarcadprof');
        exit;
    }

    try {

        $userNum = $user->contarEm($email);

        echo $userNum;

        if ($userNum == 0) {
            $user->atualizar($dados, $id);
            $_SESSION['flash_message'] = ['type' => 'sucess', 'message' => 'Atualizado com sucesso.'];
            header('Location: /mudarcadprof');
            exit;
        } 

        else {
            $_SESSION['flash_message'] = ['type' => 'danger', 'message' => 'Email já existe.'];
            header('Location: /mudarcadprof');
            exit;
        }

    } catch (Exception $e) {
        echo "Erro: " . $e->getMessage();
    }

}

?>
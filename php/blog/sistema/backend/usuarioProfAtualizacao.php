<?php

require '../Suporte/Sessao.php';
require '../Modelo/UsuarioModelo.php';

use Sistema\Suporte\Sessao;
use sistema\Modelo\UsuarioModelo;

$sessao = new Sessao;
$user = new UsuarioModelo;
$id = $sessao->user_id;


$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    $email = filter_var($dados['email'], FILTER_SANITIZE_EMAIL);
    $password = $dados['password'];

    if (empty($email)) {
        $_SESSION['flash_message'] = ['type' => 'danger', 'message' => 'Email vazio ou inválido.'];
        header('Location: /configuracoes');
        exit;
    }

    if (empty($password)) {
        $_SESSION['flash_message'] = ['type' => 'danger', 'message' => 'Senha vazia.'];
        header('Location: /configuracoes');
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['flash_message'] = ['type' => 'danger', 'message' => 'Email inválido.'];
        header('Location: /configuracoes');
        exit;
    }

    try {

        $userNum = $user->contarEm($email);

        if ($userNum == 0) {
            $user->atualizar($dados, $id);
            $_SESSION['flash_message'] = ['type' => 'success', 'message' => 'Atualizado com sucesso.'];
            header('Location: /configuracoes');
            exit;
        } else {
            $_SESSION['flash_message'] = ['type' => 'danger', 'message' => 'Email já existe.'];
            header('Location: /configuracoes');
            exit;
        }
    } catch (Exception $e) {
        echo "Erro: " . $e->getMessage();
    }
}

<?php

require_once '../Suporte/Conexao.php';
require_once '../Modelo/UsuarioModelo.php';

use sistema\Modelo\UsuarioModelo;

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    //var_dump($dados);
    $usuario = new UsuarioModelo();

    $email = filter_var($dados['email'], FILTER_SANITIZE_EMAIL);
    $password = $dados['password'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['flash_message'] = ['type' => 'danger', 'message' => 'Email inválido.'];
        header('Location: /');
        exit;
    }

    try {
       
        $user = $usuario->lerEm($email);

        // Verificar se o usuário foi encontrado e se a senha está correta
        if ($user && password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_role'] = $user['role'];
            header("Location: /dashboard");
            exit;

        } else {
            $_SESSION['flash_message'] = ['type' => 'danger', 'message' => 'Email ou senha inválidos.'];
            header('Location: /');
            exit;
        }
    } catch (Exception $e) {
        echo "Erro: " . $e->getMessage();
    }
} else {
    header("Location: /");
    exit;
}
?>

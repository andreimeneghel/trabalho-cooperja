<?php
session_start();

require_once '../Suporte/Conexao.php';
require_once '../Modelo/UsuarioModelo.php';

use sistema\Suporte\Conexao;
use sistema\Modelo\UsuarioModelo;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    //var_dump($dados);
    $usuario = new UsuarioModelo();

    // Receber e filtrar os dados do formulário
    $email = filter_var($dados['email'], FILTER_SANITIZE_EMAIL);

    // Validar o email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['flash_message'] = ['type' => 'danger', 'message' => 'Email inválido.'];
        header('Location: /');
        exit;
    }

    try {

        $count = $usuario->contarEm($email);

        if ($count > 0) {
            $_SESSION['flash_message'] = ['type' => 'danger', 'message' => 'Email já cadastrado.'];
            header('Location: /');
            exit;
        }

        $usuario->inserir($dados);
        $_SESSION['flash_message'] = ['type' => 'success', 'message' => 'Cadastro realizado com sucesso!'];

    } catch (Exception $e) {
        $_SESSION['flash_message'] = ['type' => 'danger', 'message' => 'Erro: ' . $e->getMessage()];
    }

    // Redirecionar após o processo
    header('Location: /');
    exit;
} else {
    // Caso o método não seja POST, redireciona para o formulário de cadastro
    header('Location: /');
    exit;
}
?>

<!-- Adicionar o script do Bootstrap (necessário para o funcionamento do toast) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<?php

session_start();

require_once '../Suporte/Conexao.php'; 

use sistema\Suporte\Conexao;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Receber os dados do formulário
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Validar os dados
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['flash_message'] = ['type' => 'danger', 'message' => 'Email inválido.'];
        header('Location: /');
        exit;
    }

    // Hash da senha
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    try {
        // Obter a instância da conexão
        $pdo = Conexao::getInstancia();

        // Verificar se o email já existe
        $sql = "SELECT COUNT(*) FROM tb_users WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            $_SESSION['flash_message'] = ['type' => 'danger', 'message' => 'Email já cadastrado.'];
            header('Location: /');
            exit;
        }

        // Preparar a query para inserir os dados na tabela de usuários (tb_users)
        $sql = "INSERT INTO tb_users (email, password, role) VALUES (:email, :password, :role)";
        $stmt = $pdo->prepare($sql);

        // Bind dos parâmetros
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $passwordHash);
        $stmt->bindParam(':role', $role);

        // Executar a query
        if ($stmt->execute()) {
            $_SESSION['flash_message'] = ['type' => 'success', 'message' => 'Cadastro realizado com sucesso!'];
        } else {
            $_SESSION['flash_message'] = ['type' => 'danger', 'message' => 'Erro ao realizar o cadastro.'];
        }

        header('Location: /');
        exit;

    } catch (Exception $e) {
        $_SESSION['flash_message'] = ['type' => 'danger', 'message' => 'Erro: ' . $e->getMessage()];
        header('Location: /');
        exit;
    }
} else {
    // Caso o método não seja POST, redireciona para o formulário de cadastro
    header('Location: /');
    exit;
}
?>
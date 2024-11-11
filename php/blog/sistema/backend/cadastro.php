<?php

require_once '../Suporte/Conexao.php'; 

use sistema\Suporte\Conexao;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Receber os dados do formulário
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Validar os dados
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Email inválido.");
    }

    // Hash da senha
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    try {
        // Obter a instância da conexão
        $pdo = Conexao::getInstancia();

        // Preparar a query para inserir os dados na tabela de usuários (tb_users)
        $sql = "INSERT INTO tb_users (email, password, role) VALUES (:email, :password, :role)";
        $stmt = $pdo->prepare($sql);

        // Bind dos parâmetros
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $passwordHash);
        $stmt->bindParam(':role', $role);

        // Executar a query
        if ($stmt->execute()) {
            echo "Cadastro realizado com sucesso!";
        } else {
            echo "Erro ao cadastrar usuário!";
        }

    } catch (Exception $e) {
        echo "Erro: " . $e->getMessage();
    }
} else {
    // Caso o método não seja POST, redireciona para o formulário de cadastro
    header("Location: /sistema/backend/loginUsuario.php");
    exit;
}
?>

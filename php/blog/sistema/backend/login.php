<?php

require_once '../Suporte/Conexao.php'; 

use sistema\Suporte\Conexao;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Email inválido.");
    }

    try {
        $pdo = Conexao::getInstancia();
        $sql = "SELECT * FROM tb_users WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        // Obter os dados do usuário
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificar se o usuário foi encontrado e se a senha está correta
        if ($user && password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_role'] = $user['role'];
            header("Location: /templates/site/views/dashboard.php");
            exit;
        } else {
            echo "Email ou senha inválidos.";
        }
    } catch (Exception $e) {
        echo "Erro: " . $e->getMessage();
    }
} else {
    header("Location: /sistema/templates/site/views/loginUsuario.php");
    exit;
}
?>

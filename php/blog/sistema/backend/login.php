<?php

include_once "../Modelo/UsuarioModelo.php";
use \sistema\Suporte\Conexao;
use \sistema\Modelo\UsuarioModelo;

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    $usuario = new UsuarioModelo(); 

    $email = filter_var($dados['email'], FILTER_SANITIZE_EMAIL);
    $password = $dados['password'];

    // Validação do email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['flash_message'] = ['type' => 'danger', 'message' => 'Email inválido.'];
        header('Location: /');
        exit;
    }

    try {
        // Recupera o usuário pelo email
        $user = $usuario->lerEm($email);

        // Verifica se o usuário foi encontrado e se a senha está correta
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_role'] = $user['role'];

            // Verifica se o usuário é aluno
            if ($user['role'] === 'aluno') {
                $pdo = Conexao::getInstancia();
                // Consulta para pegar as matérias do aluno
                $sql = "
                    SELECT m.nome AS materia_nome
                    FROM tb_turmas t
                    JOIN tb_materias m ON t.tb_materia_id = m.id
                    JOIN tb_alunos a ON t.id = a.tb_turma_id
                    WHERE a.tb_user_id = :user_id
                ";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':user_id', $user['id'], PDO::PARAM_INT);
                $stmt->execute();
                $materias = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // Armazena as matérias em uma variável de sessão
                $_SESSION['materias_aluno'] = $materias;

                // Redireciona o aluno para a página de acadêmicos
                header("Location: /academico");
                exit;
            } elseif ($user['role'] === 'professor') {
                // Redireciona o professor para o dashboard
                header("Location: /dashboard");
                exit;
            }
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

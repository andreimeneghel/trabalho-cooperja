<?php
session_start();

// Verificar se o usuário é um professor
if ($_SESSION['user_role'] !== 'professor') {
    die('Acesso restrito! Somente professores podem cadastrar notas e presença.');
}

// Conexão com o banco de dados
require_once '../Suporte/Conexao.php';
use sistema\Suporte\Conexao;

// Inicializa o banco de dados
$pdo = Conexao::getInstancia();

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Receber os dados do formulário
    $materia_id = $_POST['materia_id'];
    $presencas = $_POST['presenca'] ?? [];
    $notas = $_POST['nota'];
    $data = date('Y-m-d');

    foreach ($notas as $aluno_id => $nota) {
        // Definir presença como 0 se o checkbox não foi marcado
        $presenca = $presencas[$aluno_id] ?? 0;

        // Verificar se a nota está entre 0 e 10
        if ($nota < 0 || $nota > 10) {
            die("Nota inválida. A nota deve ser entre 0 e 10.");
        }

        try {
            // Verificar se já existe um registro para o aluno e matéria
            $stmt = $pdo->prepare("
                SELECT * FROM tb_notas_presenca 
                WHERE tb_aluno_id = :aluno_id AND tb_materia_id = :materia_id
            ");
            $stmt->bindParam(':aluno_id', $aluno_id, PDO::PARAM_INT);
            $stmt->bindParam(':materia_id', $materia_id, PDO::PARAM_INT);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_OBJ);

            if ($resultado && $resultado->data === $data) {
                // Atualizar a nota e presença sem alterar a data
                $stmt = $pdo->prepare("
                    UPDATE tb_notas_presenca 
                    SET nota = :nota, presenca = :presenca
                    WHERE tb_aluno_id = :aluno_id AND tb_materia_id = :materia_id AND data = :data
                ");
                $stmt->bindParam(':data', $data); // Usar o valor atual de $data
            } else {
                // Inserir um novo registro
                $stmt = $pdo->prepare("
                    INSERT INTO tb_notas_presenca (tb_aluno_id, tb_materia_id, nota, presenca, data) 
                    VALUES (:aluno_id, :materia_id, :nota, :presenca, :data)
                ");
                $stmt->bindParam(':data', $data);
            }

            // Executar a query
            $stmt->bindParam(':aluno_id', $aluno_id, PDO::PARAM_INT);
            $stmt->bindParam(':materia_id', $materia_id, PDO::PARAM_INT);
            $stmt->bindParam(':nota', $nota);
            $stmt->bindParam(':presenca', $presenca);

            if ($stmt->execute()) {

                $_SESSION['flash_message'] = ['type' => 'success', 'message' => 'Cadastro/Atualização de nota e presença realizado com sucesso'];
            } else {
                $_SESSION['flash_message'] = ['type' => 'danger', 'message' => 'Erro ao cadastrar dados para o aluno, tente novamente.'];
            }
        } catch (Exception $e) {
            echo "Erro: " . $e->getMessage();
        }
    }
    
    header('Location: /turmas');
}
?>

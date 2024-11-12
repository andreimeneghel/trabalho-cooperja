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
    // Receber os dados dos alunos
    $presencas = $_POST['presenca'] ?? [];  // Array de presenças (ou array vazio se não houver presença marcada)
    $notas = $_POST['nota'];                // Array de notas

    foreach ($notas as $aluno_id => $nota) {
        // Definir presença como 0 se o checkbox não foi marcado
        $presenca = $presencas[$aluno_id] ?? 0;

        // Buscar o ID da matéria para o aluno atual
        $stmt = $pdo->prepare("SELECT tb_materia_id FROM tb_notas_presenca WHERE tb_aluno_id = :aluno_id LIMIT 1");
        $stmt->bindParam(':aluno_id', $aluno_id, PDO::PARAM_INT);
        $stmt->execute();
        $resultadoMateria = $stmt->fetch(PDO::FETCH_OBJ);

        if (!$resultadoMateria) {
            // Defina um valor padrão ou apresente uma mensagem de erro se a matéria não for encontrada
            die("Erro: matéria não encontrada para o aluno com ID $aluno_id.");
        }

        $materia_id = $resultadoMateria->tb_materia_id;

        // Verificar se a nota está entre 0 e 10
        if ($nota < 0 || $nota > 10) {
            die("Nota inválida. A nota deve ser entre 0 e 10.");
        }

        try {
            // Verificar se já existe um registro para o aluno e matéria
            $stmt = $pdo->prepare("SELECT * FROM tb_notas_presenca WHERE tb_aluno_id = :aluno_id AND tb_materia_id = :materia_id");
            $stmt->bindParam(':aluno_id', $aluno_id, PDO::PARAM_INT);
            $stmt->bindParam(':materia_id', $materia_id, PDO::PARAM_INT);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_OBJ);

            if ($resultado) {
                // Atualizar a nota e presença
                $stmt = $pdo->prepare("UPDATE tb_notas_presenca SET nota = :nota, presenca = :presenca WHERE tb_aluno_id = :aluno_id AND tb_materia_id = :materia_id");
            } else {
                // Inserir um novo registro
                $stmt = $pdo->prepare("INSERT INTO tb_notas_presenca (tb_aluno_id, tb_materia_id, nota, presenca) VALUES (:aluno_id, :materia_id, :nota, :presenca)");
            }

            // Executar a query
            $stmt->bindParam(':aluno_id', $aluno_id, PDO::PARAM_INT);
            $stmt->bindParam(':materia_id', $materia_id, PDO::PARAM_INT);
            $stmt->bindParam(':nota', $nota);
            $stmt->bindParam(':presenca', $presenca);
            
            if ($stmt->execute()) {
                echo "<p>Cadastro de nota e presença realizado com sucesso para o aluno $aluno_id!</p>";
            } else {
                echo "<p>Erro ao cadastrar dados para o aluno $aluno_id. Tente novamente.</p>";
            }
        } catch (Exception $e) {
            echo "Erro: " . $e->getMessage();
        }
    }
}
?>

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
    $materia_id = $_POST['materia_id'];  // Matéria selecionada no formulário
    $presencas = $_POST['presenca'] ?? [];  // Array de presenças
    $notas = $_POST['nota'];                // Array de notas

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

            if ($resultado) {
                // Atualizar a nota e presença
                $stmt = $pdo->prepare("
                    UPDATE tb_notas_presenca 
                    SET nota = :nota, presenca = :presenca 
                    WHERE tb_aluno_id = :aluno_id AND tb_materia_id = :materia_id
                ");
            } else {
                // Inserir um novo registro
                $stmt = $pdo->prepare("
                    INSERT INTO tb_notas_presenca (tb_aluno_id, tb_materia_id, nota, presenca) 
                    VALUES (:aluno_id, :materia_id, :nota, :presenca)
                ");
            }

            // Executar a query
            $stmt->bindParam(':aluno_id', $aluno_id, PDO::PARAM_INT);
            $stmt->bindParam(':materia_id', $materia_id, PDO::PARAM_INT);
            $stmt->bindParam(':nota', $nota);
            $stmt->bindParam(':presenca', $presenca);

            if ($stmt->execute()) {
                echo "<p>Cadastro de nota e presença realizado com sucesso para o aluno ID $aluno_id!</p>";
            } else {
                echo "<p>Erro ao cadastrar dados para o aluno ID $aluno_id. Tente novamente.</p>";
            }
        } catch (Exception $e) {
            echo "Erro: " . $e->getMessage();
        }
    }
}
?>

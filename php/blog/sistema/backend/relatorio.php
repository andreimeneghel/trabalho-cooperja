<?php
session_start();

if ($_SESSION['role'] !== 'professor') {
    die('Você não tem permissão para acessar esta página.');
}

require_once '../Suporte/Conexao.php';

use sistema\Suporte\Conexao;

$turma_id = $_GET['turma_id'];  // Parâmetro para filtrar por turma
$materia_id = $_GET['materia_id'];  // Parâmetro para filtrar por matéria

try {
    $pdo = Conexao::getInstancia();

    // Consulta para gerar relatório
    $sql = "SELECT a.nome AS aluno, np.nota, np.presenca
            FROM tb_notas_presenca np
            JOIN tb_alunos a ON np.tb_aluno_id = a.id
            WHERE np.tb_materia_id = :materia_id";

    // Filtra por turma
    if ($turma_id) {
        $sql .= " AND a.tb_turma_id = :turma_id";
    }

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':materia_id', $materia_id);
    if ($turma_id) {
        $stmt->bindParam(':turma_id', $turma_id);
    }
    $stmt->execute();

    $relatorio = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<h3>Relatório de Notas e Frequência</h3>";
    echo "<table border='1'>
            <tr>
                <th>Aluno</th>
                <th>Nota</th>
                <th>Presença</th>
            </tr>";

    foreach ($relatorio as $linha) {
        echo "<tr>
                <td>" . htmlspecialchars($linha['aluno']) . "</td>
                <td>" . htmlspecialchars($linha['nota']) . "</td>
                <td>" . ($linha['presenca'] == 1 ? 'Presente' : 'Ausente') . "</td>
              </tr>";
    }

    echo "</table>";
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}

<?php
session_start();

$BASE_URL = "http://" . $_SERVER['SERVER_NAME'] . ":" . $_SERVER['SERVER_PORT'] . "/sistema/backend/";

use sistema\Suporte\Conexao;

try {
    $conn = Conexao::getInstancia();
    $userId = $_SESSION['user_id'];

    // Consulta para pegar as matérias, notas e presenças do aluno
    $stmtNotas = $conn->prepare("
        SELECT m.nome AS materia, np.nota, np.presenca
        FROM tb_notas_presenca np
        JOIN tb_materias m ON m.id = np.tb_materia_id
        JOIN tb_alunos a ON a.id = np.tb_aluno_id
        WHERE a.tb_user_id = :userId
    ");
    $stmtNotas->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmtNotas->execute();
    $materiasNotas = $stmtNotas->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    die("Erro ao carregar os dados: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Acadêmico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
</head>

<body>

    <header class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Dashboard Acadêmico</a>
            <div class="d-flex ms-auto">
                <a class="btn btn-outline-light btn-sm" href="<?= $BASE_URL ?>logout.php">Sair</a>
            </div>
        </div>
    </header>

    <div class="container-fluid">
        <main class="container mt-5 mx-auto">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2 text-dark">Tabela Acadêmica</h1>
                <p class="text-muted">Aqui você pode visualizar suas matérias, notas e faltas.</p>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-12">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Matéria</th>
                                        <th>Nota</th>
                                        <th>Faltas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($materiasNotas) {
                                        foreach ($materiasNotas as $materiaNota) {
                                            $faltas = 1 - $materiaNota['presenca']; // Calcula o número de faltas
                                            echo "<tr>
                                                <td>{$materiaNota['materia']}</td>
                                                <td>{$materiaNota['nota']}</td>
                                                <td>{$faltas}</td>
                                            </tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='3'>Nenhuma matéria encontrada</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center mt-3">
                <a href="/academico" class="btn btn-primary">Voltar ao Dashboard</a>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
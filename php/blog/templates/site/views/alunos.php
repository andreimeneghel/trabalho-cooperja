<?php
session_start();

use sistema\Suporte\Conexao;


$pdo = Conexao::getInstancia();


$stmt = $pdo->prepare("
    SELECT t.id, t.nome 
    FROM tb_turmas t
    INNER JOIN tb_professores p ON t.tb_professor_id = p.id
    WHERE p.tb_user_id = :user_id
");

$stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
$stmt->execute();
$turmas = $stmt->fetchAll(PDO::FETCH_ASSOC);


$alunos = [];
$nome_aluno = '';

if (isset($_GET['turma_id'])) {
    $turma_id = (int) $_GET['turma_id'];


    if (isset($_GET['nome_aluno']) && !empty($_GET['nome_aluno'])) {
        $nome_aluno = $_GET['nome_aluno'];
        $stmt = $pdo->prepare("SELECT a.id, a.nome 
                               FROM tb_alunos a 
                               WHERE a.tb_turma_id = :turma_id 
                               AND a.nome LIKE :nome_aluno");
        $nome_aluno_param = '%' . $nome_aluno . '%';
        $stmt->bindParam(':turma_id', $turma_id, PDO::PARAM_INT);
        $stmt->bindParam(':nome_aluno', $nome_aluno_param, PDO::PARAM_STR);
    } else {
        $stmt = $pdo->prepare("SELECT a.id, a.nome 
                               FROM tb_alunos a 
                               WHERE a.tb_turma_id = :turma_id");
        $stmt->bindParam(':turma_id', $turma_id, PDO::PARAM_INT);
    }

    $stmt->execute();
    $alunos = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Alunos</title>
    <link rel="stylesheet" href="/templates/site/assets/css/alunos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>

    <?php include 'header.php'; ?>
    <div class="row m-0" style="min-height: 100vh">

        <?php include 'sidebar.php'; ?>

        <div class="container mt-3 col-9 ">
            <h2 class="mb-4 text-white text-center">Selecionar Turma e Ver Alunos</h2>

            <div class="main-container p-4 rounded shadow-sm">
                <div class="search-container">
                    <form method="GET" action="" class="d-flex  gap-3 align-items-end">
                        <div class="flex-grow-1 text-white">
                            <label for="turmaSelect" class="form-label fw-bold">Selecione uma Turma:</label>
                            <select class="form-select border-primary" name="turma_id" id="turmaSelect" onchange="this.form.submit()">
                                <option value="" class="text-muted">Escolha uma turma...</option>
                                <?php foreach ($turmas as $turma): ?>
                                    <option value="<?= $turma['id']; ?>" <?= isset($_GET['turma_id']) && $_GET['turma_id'] == $turma['id'] ? 'selected' : '' ?>>
                                        <?= $turma['nome']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="flex-grow-1 text-white">
                            <label for="nome_aluno" class="form-label fw-bold">Pesquisar Aluno:</label>
                            <input type="text" class="form-control border-primary" name="nome_aluno" id="nome_aluno" value="<?= htmlspecialchars($nome_aluno); ?>" placeholder="Nome do aluno">
                        </div>
                    </form>
                </div>

                <div class="alunos-container mt-5">
                    <h3 class="text-white text-center mb-3">Alunos:</h3>
                    <ul class="list-group list-group-flush shadow-sm" id="alunosList" style="background-color: #fff;">
                        <?php if (!empty($alunos)): ?>
                            <?php foreach ($alunos as $aluno): ?>
                                <li class="list-group-item text-dark"><?= $aluno['nome']; ?></li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li class="list-group-item text-muted text-center">Nenhum aluno encontrado para esta turma.</li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </div>
</div>
</body>


</html>